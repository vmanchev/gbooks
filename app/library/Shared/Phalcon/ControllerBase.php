<?php

namespace Shared\Phalcon;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

/**
 * Class ControllerBase
 */
class ControllerBase extends Controller
{
    public function initialize()
    {
        $this->view->url = $this->url;
    }
    
    /**
     * @param $param
     * @param null $default
     * @param null $ctype
     * @param null $filters
     * @return mixed|null
     * @throws \Exception
     */
    public function getParam($param, $default = null, $ctype = null, $filters = null)
    {
        $value = $this->getDispatcherParam($param, $filters);
        $value = empty($value) ? $default : $value;
        
        if (!empty($ctype)) {
            $function = 'ctype_' . $ctype;
            if (!function_exists($function)) {
                throw new \Exception('Ctype ' . $ctype . ' not possible.');
            }
            $value = ($function($value)) ? $value : $default;
        }

        return $value;
    }
    
    /**
     * Alias for $this->dispatcher->getParam
     *
     * @param $param
     * @param $filters
     * @return mixed
     */
    public function getDispatcherParam($param, $filters = null)
    {
        return $this->dispatcher->getParam($param, $filters);
    }
    
    /**
     * 
     * @return config array
     */
    protected function getConfig()
    {
        return $this->config;
    }
    

    protected function setFlashErrorMessages(array $messages = null)
    {
        if(count($messages) > 0){
            foreach ($messages as $message) {
                $this->flash->error($message);
            }
        }
        
        return true;
    }
}

