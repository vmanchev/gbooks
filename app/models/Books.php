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

    /**
     * Custom search for books in a local MongoDB collection
     * 
     * Due to MongoDB nature, we need to prepare the search query in a bit 
     * different way. Here we are building the WHERE clause and pass it to the 
     * Mongo's find() method.
     * 
     * @param array $params Associative array, possible keys - "title", "author", 
     * "keywords", where "keywords" is expected to be an array of keywords.
     * @return array
     */
    public static function customSearch(array $params)
    {
        //defaults to an empty array
        $where = array();
        
        //search by title
        if(isset($params['title'])){
            $where['volumeInfo.title'] = new \MongoRegex('/'.$params['title'].'/i');
        }
        
        //search by author
        if(isset($params['author'])){
            $where['volumeInfo.authors'] = array(
                '$in' => array(new \MongoRegex('/'.$params['author'].'/i'))
            );
        }
        
        //search book description by keywords
        if(isset($params['keywords']) && is_array($params['keywords'])){
            
            $kw = array();
            
            foreach($params['keywords'] as $k){
                $kw[] = new \MongoRegex('/'.$k.'/i');
            }
            
            $where['volumeInfo.description'] = array('$in' => $kw);
        }        
        
        return self::find(array($where));
    }

}
