<?php

namespace Modules\Frontend\Controllers;

use Prodio\Http\Client as HttpClient;
use Prodio\Http\Exception\Curl as CurlException;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        
    }

    public function searchAction()
    {
        $this->view->disable();

        $title = $this->request->getPost('search');
        $HttpClient->setMethod('POST')
                ->setUrl('https://www.googleapis.com/books/v1/volumes')
                ->setParams(array(
                    'q' => $title,
        ));

        try {
            $response = $HttpClient->send();
            return json_encode($response);
        } catch (CurlException $ex) {
            echo $ex->getMessage();
        }
    }

}
