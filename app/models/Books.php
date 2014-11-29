<?php

namespace Models;

class Books extends \Phalcon\Mvc\Collection {

    public function hydrate($data)
    {

        foreach ($data as $key => $value)
        {
            $this->$key = $value;
        }
        
        return $this;
    }

}