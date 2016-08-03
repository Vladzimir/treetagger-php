<?php
/**
 * PHP interface for TreeTagger
 * http://www.cis.uni-muenchen.de/~schmid/tools/TreeTagger/
 *
 * @package TreeTagger
 * @version 0.1.0
 * @author Nicolas Kahn <nkahn@la-metis.fr>
 */
namespace TreeTagger;

class TreeTagger extends Base
{
    const COMMAND_DIR    = 'cmd';
    const COMMAND_PREFIX = 'tree-tagger-';

    /**
     * Text language (English by default)
     */
    protected $language = 'english';


    /**
     * Constructor!
     *
     * @return null
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Language setter
     *
     * @param $type
     *
     * @return null
     */
    public function setLanguage($lang)
    {
        $command = $this->_getCommandPath($lang);
        //echo "TreeTagger Command: {$command}\n";
        if (is_executable($command)) {
            $this->language = $lang;
        } else {
            throw new Exception("Language '{$lang}' is not supported!");
        }
    }

    /**
     * Language getter
     *
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Returns the path of the TreeTagger command to be used with specified language.
     * @param  $language string selected language
     * @return string path to the the TreeTagger command to be used with selected language
     */
    protected function _getCommandPath($language)
    {
        return rtrim($this->getPath(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR
            . self::COMMAND_DIR . DIRECTORY_SEPARATOR . self::COMMAND_PREFIX . $language;
    }

    /**
     * Tag from an array of tokens for a sentence
     *
     * @param $tokens array tokens
     *
     * @return mixed
     */
    public function tag($tokens)
    {
        return $this->batchTag(array($tokens));
    }

    /**
     * Tag multiple arrays of tokens for sentences
     *
     * @param $sentences array array of arrays of tokens
     *
     * @return mixed
     */
    public function batchTag($sentences)
    {
        // Reset errors and output
        $this->setErrors(null);
        $this->setOutput(null);

        // Make temp file to store sentences.
        $tmpfname = tempnam(sys_get_temp_dir(), 'phpnlptag');
        chmod($tmpfname, 0644);
        $handle = fopen($tmpfname, 'w');

        foreach ($sentences as $k => $v) {
            $sentences[$k] = implode("\n", $v);
        }
        $str = implode("\n", $sentences);

        fwrite($handle, $str);
        fclose($handle);

        // Create process to run tree-tagger script
        $descriptorspec = array(
           0 => array('pipe', 'r'),  // stdin
           1 => array('pipe', 'w'),  // stdout
           2 => array('pipe', 'w')   // stderr
        );

        $path    = $this->getPath();
        $command = $this->_getCommandPath($this->getLanguage());
        $cmd     = escapeshellcmd("{$command} {$tmpfname}");

        $process = proc_open($cmd, $descriptorspec, $pipes, $path);

        $output = null;
        $errors = null;
        if (is_resource($process)) {
            // we aren't working with stdin
            fclose($pipes[0]);

            // get output
            $output = stream_get_contents($pipes[1]);
            fclose($pipes[1]);

            // get any errors
            $errors = stream_get_contents($pipes[2]);
            fclose($pipes[2]);

            // close pipe before calling proc_close in order to avoid a deadlock
            $return_value = proc_close($process);
            if ($return_value == -1) {
                throw new Exception("TreeTagger returned with an error ({$return_value}).");
            }
        }

        unlink($tmpfname);

        if ($errors) {
            $this->setErrors($errors);
        }

        if ($output) {
            $this->setOutput($output);
        }

        return $this->parseOutput();
    }

    /**
     * Build text output from TreeTagger into array structure
     *
     * @return array
     */
    public function parseOutput()
    {
        $arr    = array();
        $output = $this->getOutput();

        if ($output) {
            $lines = explode("\n", $output);
            foreach ($lines as $line) {
                if (trim($line) == '') {
                    continue;
                }
                $parts = explode("\t", trim($line));
                $arr[] = $parts;
            }
        }

        return $arr;
    }
}
