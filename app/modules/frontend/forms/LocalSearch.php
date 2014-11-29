<?php

namespace Modules\Frontend\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;

class LocalSearch extends Form 
{
    public function initialize()
    {
        $title = new Text('title');
        $title->setLabel('Book title:')
            ->setFilters(array('striptags', 'string', 'trim', 'lower'));
        $this->add($title);
        
        $author = new Text('author');
        $author->setLabel('Author:')
            ->setFilters(array('striptags', 'string', 'trim', 'lower'));
        $this->add($author);
        
        $keywords = new Text('keywords');
        $keywords->setLabel('Keywords:')
            ->setFilters(array('striptags', 'string', 'trim', 'lower'));
        $this->add($keywords);
    }    
}