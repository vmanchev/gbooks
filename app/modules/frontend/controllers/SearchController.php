<?php

namespace Modules\Frontend\Controllers;

use Modules\Frontend\Forms\LocalSearch as SearchForm;
use Gbooks\Models\Books as BooksModel;

class SearchController extends ControllerBase
{

    public function localAction()
    {
        $form = new SearchForm();


        if ($this->request->has('sq')) {
            $this->view->results = BooksModel::customSearch($this->getSearchParams());
        }

        $this->view->form = $form;
    }

    private function getSearchParams()
    {
        $data = array('title' => '', 'author' => '', 'keywords' => array());

        $data['title'] = $this->getFilteredParam('title');
        $data['author'] = $this->getFilteredParam('author');

        $data['keywords'] = $this->getFilteredParam('keywords');

        if (!empty($data['keywords'])) {
            $data['keywords'] = array_filter(explode(',', $data['keywords']), 'trim');
        }
        
        return array_filter($data);
    }

    private function getFilteredParam($key)
    {
        return $this->request->get($key, array('striptags', 'string', 'trim'));
    }

}
