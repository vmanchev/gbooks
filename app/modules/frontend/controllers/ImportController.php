<?php

namespace Modules\Frontend\Controllers;

use Prodio\Http\Client as HttpClient;
use Gbooks\Models\Books as BooksModel;

/**
 * Imports books from Google Books API into a local database
 */
class ImportController extends ControllerBase {

    const MAX_RESULTS = 40;

    public function initialize()
    {
        $this->view->disable();
    }
    
    /**
     * Imports up to 1000 books from O'reilly
     */
    public function indexAction()
    {
        for ($i = 0; $i <= 1000; $i+=40)
        {
            $client = new HttpClient();
            $client->setUrl($this->gbooksapi)
                    ->setMethod('GET')
                    ->setParams(array(
                        'q' => 'inpublisher:reilly',
                        'startIndex' => $i,
                        'maxResults' => self::MAX_RESULTS
            ));

            $results = json_decode($client->send());

            

            foreach ($results->items as $item)
            {
                $booksModel = new BooksModel();
                $booksModel->hydrate($item)->save();
            }
        }

        $this->response->redirect(array('for'=>'import_status'));
        
    }
    
    /**
     * Display the number of books in the database
     */
    public function statusAction()
    {
        echo BooksModel::count().' books in the database';
    }
}
