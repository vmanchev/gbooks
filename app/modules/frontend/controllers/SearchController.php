<?php

namespace Modules\Frontend\Controllers;

use Modules\Frontend\Forms\LocalSearch as SearchForm;
use Gbooks\Models\Books as BooksModel;

/**
 * Search for books
 */
class SearchController extends ControllerBase
{

    /**
     * Search in a local database
     */
    public function localAction()
    {
        //Determinates when the form has been submitted
        if ($this->request->has('sq')) {
            //Perform a search and pass results to the view
            $this->view->results = BooksModel::customSearch($this->getSearchParams());
        }

        //initialize the search form and pass it to the view
        $this->view->form = new SearchForm();
    }

    /**
     * Filter request/search parameteres
     * 
     * @return array Associative array of filtered and non-empty parameters
     */
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

    /**
     * Request parameter filter
     * 
     * Apply a filter chain over a request parameter - strip html tags and trim
     * 
     * @param string $key 
     * @return string
     */
    private function getFilteredParam($key)
    {
        return $this->request->get($key, array('striptags', 'string', 'trim'));
    }

}
