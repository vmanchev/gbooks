<?php




namespace Prodio\XML;




require_once 'XML/Unserializer.php';




class Unserializer extends \XML_Unserializer
{
    public function __construct($options)
    {
        parent::__construct($options);
    }

    
    
    
    public function unserialize($data)
    {
        $result = parent::unserialize($data);
        
        if (XML_UNSERIALIZER_OPTION_RETURN_RESULT)
        {
            file_put_contents('/tmp/xml/' . time() . '.xml', $result);
        }
        else
        {
            file_put_contents('/tmp/xml/' . time() . '.xml', $this->getUnserializedData()); 
        }

        return $result;
    }

}
