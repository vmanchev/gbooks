<?php

namespace Prodio;

class Error
{

    const ERROR_ACCESS_DENIED = 'BBE_ERROR_1';
    const ERROR_UNAUTHORIZED = 'BBE_ERROR_2';
    const ERROR_CONTENT_TYPE = 'BBE_ERROR_3';

    private $messages = array(
        'BBE_ERROR_1' => 'Access denied',
        'BBE_ERROR_2' => 'Unauthorized',
        'BBE_ERROR_3' => 'Content type is not specified'
    );
    private $requestType;
    private $errorType;

    public function getErrorType()
    {
        return $this->errorType;
    }

    public function setErrorType($errorType)
    {
        $this->errorType = $errorType;
        return $this;
    }

    public function getRequestType()
    {
        return $this->requestType;
    }

    public function setRequestType($requestType)
    {
        $this->requestType = $requestType;
        return $this;
    }

    public function __toString()
    {
        $data = array('error' => array(
                'message' => $this->messages[$this->errorType]
        ));

        if ($this->requestType == 'xml') {
            return '<bbeResponse><errors><error><code>'.$this->errorType.'</code><message>' . $this->messages[$this->errorType] . '</message></error></errors></bbeResponse>';
        }else{
            return json_encode($data);
        }
    }

}
