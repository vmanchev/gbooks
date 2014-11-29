<?php

namespace Shared\Phalcon;

use Shared\Phalcon\Model as SharedModel;

class ModelSoftDelete extends SharedModel
{
    public static function find($parameters = null)
    {
        $params = array('conditions' => null, 'bind' => null);
    
        if (is_array($parameters) && !isset($parameters['conditions'])) {
            $idx = 0;
            while (array_key_exists($idx, $parameters)) {
                $params['conditions'] .= $parameters[$idx] . ' AND ';
                if (isset($parameters['bind'][$idx])) {
                    $params['bind'][$idx] = $parameters['bind'][$idx];
                }
                $idx++;
            }
            if (!empty($parameters['bind']) && is_array($parameters['bind'])) {
                foreach ($parameters['bind'] as $key => $value) {
                    $params['bind'][$key] = $value;
                }
            }
            $params['conditions'] .= ' status = ?' . $idx;
            $params['bind'][$idx] = self::OP_CREATE;
            $parameters = $params;
        } else if (empty($parameters)) {
            $idx = 1;
            $params['conditions'] .= ' status = ?' . $idx;
            $params['bind'][$idx] = self::OP_CREATE;
            $parameters = $params;
        }
        
        unset($params);
        return parent::find($parameters);
    }
    
    public static function findFirst($parameters = null)
    {
        $params = array('conditions' => null, 'bind' => null);
    
        if (is_array($parameters) && !isset($parameters['conditions'])) {
            $idx = 0;
            while (array_key_exists($idx, $parameters)) {
                $params['conditions'] .= $parameters[$idx] . ' AND ';
                if (isset($parameters['bind'][$idx])) {
                    $params['bind'][$idx] = $parameters['bind'][$idx];
                }
                $idx++;
            }
            if (!empty($parameters['bind']) && is_array($parameters['bind'])) {
                foreach ($parameters['bind'] as $key => $value) {
                    $params['bind'][$key] = $value;
                }
            }
            $params['conditions'] .= ' status = ?' . $idx;
            $params['bind'][$idx] = self::OP_CREATE;
            $parameters = $params;
        } else if (empty($parameters)) {
            $idx = 1;
            $params['conditions'] .= ' status = ?' . $idx;
            $params['bind'][$idx] = self::OP_CREATE;
            $parameters = $params;
        }
        
        unset($params);
    
        return parent::findFirst($parameters);
    }
}
