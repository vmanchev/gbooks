<?php

namespace Modules\Frontend\Controllers;

use Prodio\Http\Client as HttpClient;

class ImportController extends ControllerBase {

    const MAX_RESULTS = 40;

    public function indexAction()
    {
        $this->view->disable();


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
                $booksModel = new \Models\Books();
                $booksModel->hydrate($item)->save();
            }
        }

        echo "ok";
        
    }
    

}
