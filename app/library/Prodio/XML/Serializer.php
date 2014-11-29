<?php




namespace Prodio\XML;




require_once 'XML/Serializer.php';




class Serializer extends \XML_Serializer
{
    public function serialize($data)
    {
        $result = parent::serialize($data);
        
        if (XML_SERIALIZER_OPTION_RETURN_RESULT)
        {
            file_put_contents('/tmp/xml/' . time() . '.xml', $result);
            return $result;
        }
        else
        {
            file_put_contents('/tmp/xml/' . time() . '.xml', $this->getSerializedData()); 
            return $this->getSerializedData();
        }
    }
}
