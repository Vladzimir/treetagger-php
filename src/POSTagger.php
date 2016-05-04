<?php
/**
 * PHP interface for TreeTagger (POS and lemma Tagger)
 * http://www.cis.uni-muenchen.de/~schmid/tools/TreeTagger/
 *
 * Part-Of-Speech Tag Lists
 * EN: http://www.cis.uni-muenchen.de/~schmid/tools/TreeTagger/data/Penn-Treebank-Tagset.pdf
 * FR: http://www.cis.uni-muenchen.de/~schmid/tools/TreeTagger/data/french-tagset.html
 *
 * @package TreeTagger
 * @version 0.1.0
 * @author Nicolas Kahn <nkahn@la-metis.fr>
 */
namespace TreeTagger;

class POSTagger extends TreeTagger
{
    /**
     * Constructor!
     *
     * @param $path string path to TreeTagger directory
     *
     * @return null
     */
    public function __construct($path)
    {
        parent::__construct();
        $this->setPath($path);
    }

    /**
     * Tag multiple arrays of tokens for sentences
     *
     * @param $sentences array array of arrays of tokens
     *
     * @return mixed
     */
    public function batchTag($sentences, $lang = 'english')
    {
        $this->setLanguage($lang);
        return parent::batchTag($sentences);
    }
}
