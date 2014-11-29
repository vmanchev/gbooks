<?php

namespace Modules\Frontend\Controllers;

use Prodio\Http\Client as HttpClient;


class ImportController extends ControllerBase {

    const MAX_RESULTS = 40;

    public function initialize()
    {
        $this->view->disable();
    }
    
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

        echo "ok";
        
    }
    
    public function statusAction()
    {
        echo \Gbooks\Models\Books::count().' books in the database';
    }
}
