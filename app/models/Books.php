<?php

namespace Gbooks\Models;

class Books extends \Phalcon\Mvc\Collection
{

    public function hydrate($data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }

        return $this;
    }

    public static function customSearch(array $params)
    {
        $where = array();
        
        if(isset($params['title'])){
            $where['volumeInfo.title'] = new \MongoRegex('/'.$params['title'].'/i');
        }
        
        if(isset($params['author'])){
            $where['volumeInfo.authors'] = array('$in' => array(new \MongoRegex('/'.$params['author'].'/i')));
        }
        
        if(isset($params['keywords'])){
            
            $kw = array();
            
            foreach($params['keywords'] as $k){
                $kw[] = new \MongoRegex('/'.$k.'/i');
            }
            
            $where['volumeInfo.description'] = array('$in' => $kw);
        }        
        
        return self::find(array($where));
    }

}
