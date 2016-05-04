<?php
/**
 * This file is part of the TreeTagger for PHP.
 *
 * Base class, providing core functionality for several classes.
 *
 * @package TreeTagger
 * @version 0.1.0
 * @author Nicolas Kahn <nkahn@la-metis.fr>
 */
namespace TreeTagger;

/**
 * Base class for TreeTagger NLP
 */
class Base
{
    /**
     * Relative/absolute path to TreeTagger directory
     */
    protected $path;

    /**
     * Relative/absolute path to tokenizer abbreviations file
     */
    protected $tokenizer_abbr_file;

    /**
     * Tokenizer options
     */
    protected $tokenizer_options;

    /**
     * Relative/absolute path to tagger parameter file
     */
    protected $tagger_param_file;

    /**
     * Tagger options
     */
    protected $tagger_options;

    /**
     * Output from NLP Tool
     */
    protected $output = null;

    /**
     * Errors from NLP Tool
     */
    protected $errors = null;


    /**
     * Constructor!
     *   - Set PHP Operating System.
     *
     * @return null
     */
    public function __construct()
    {
        if (defined('PHP_OS')) {
            if (strtolower(substr(PHP_OS, 0, 3)) == 'win') {
                throw new Exception('This TreeTagger library does not support Windows OS!');
            }
        }
    }

    /**
     * TreeTagger path setter
     *
     * @param $path string path to TreeTagger directory
     *
     * @return null
     */
    public function setPath($path)
    {
        if (is_dir($path)) {
            $this->path = $path;
        } else {
            throw new Exception("Path '{$path}' is not a valid directory!");
        }
    }

    /**
     * TreeTagger path getter
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Tokenizer abbreviations file setter
     *
     * @param $path string path to tokenizer abbreviations file
     *
     * @return null
     */
    public function setTokenizerAbbrFile($path)
    {
        $this->tokenizer_abbr_file = $path;
    }

    /**
     * Tokenizer abbreviations file getter
     *
     * @return string
     */
    public function getTokenizerAbbrFile()
    {
        return $this->tokenizer_abbr_file;
    }

    /**
     * Tokenizer options setter
     *
     * @param $options mixed options
     *
     * @return null
     */
    public function setTokenizerOptions($options)
    {
        $this->tokenizer_options = (array) $options;
    }

    /**
     * Tokenizer options getter
     *
     * @return array
     */
    public function getTokenizerOptions()
    {
        return $this->tokenizer_options;
    }

    /**
     * Tagger parameter file setter
     *
     * @param string path to tagger parameter file
     *
     * @return null
     */
    public function setTaggerParamFile($path)
    {
        $this->tagger_param_file = $path;
    }

    /**
     * Tagger parameter file getter
     *
     * @return string
     */
    public function getTaggerParamFile()
    {
        return $this->tagger_param_file;
    }

    /**
     * Tagger options setter
     *
     * @param $options mixed options
     *
     * @return null
     */
    public function setTaggerOptions($options)
    {
        $this->tagger_options = (array) $options;
    }

    /**
     * Tagger options getter
     *
     * @return array
     */
    public function getTaggerOptions()
    {
        return $this->tagger_options;
    }

    /**
     * Output setter
     *
     * @param $output
     *
     * @return null
     */
    public function setOutput($output)
    {
        $this->output = $output;
    }

    /**
     * Output getter
     *
     * @return mixed
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * Errors setter
     *
     * @param $errors
     *
     * @return null
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * Errors getter
     *
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
