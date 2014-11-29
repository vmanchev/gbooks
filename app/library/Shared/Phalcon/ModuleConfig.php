<?php

namespace Shared\Phalcon;

use Phalcon\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View;
use Phalcon\Text;

/**
 * This is an extensible Module configurator for Multi Module app. Just extend and give it a namespace
 * equal to module name, and it should work.
 *
 * Class ModuleConfig
 */
class ModuleConfig implements ModuleDefinitionInterface
{
    /** @var string */
    protected $reflectionPath = '';
    /** @var null */
    protected $config         = null;
    
    public function registerAutoloaders()
    {
    }
    
    /**
     * Register specific services for the module
     */
    public function registerServices($di)
    {
        /** @var Dispatcher $dispatcher */
        $dispatcher = $di->get('dispatcher');
        $reflectionPath = explode(DIRECTORY_SEPARATOR, trim($this->getReflectionPath(), '/'));
        $moduleName = array_pop($reflectionPath);
        $dispatcher->setDefaultNamespace("Modules\\". ucfirst($moduleName) ."\Controllers\\");
        $eventsManager = $di->getShared('eventsManager');
        // dash in URI
        $eventsManager->attach("dispatch:beforeDispatchLoop", function($event, $dispatcher) {
            $actionName = preg_replace_callback(
                    '!^[A-Z]{1}!',
                    function ($matches) {
                        return strtolower($matches[0]);
                    },
                    Text::camelize((string) $dispatcher->getActionName())
            );

            $dispatcher->setActionName($actionName);
        });
        
        $di->set('dispatcher', $dispatcher);
        
        //Registering the view component
        /** @var View $view */
        $view = $di->get('view');
        $path = $this->getReflectionPath();
        $view->setViewsDir($path . 'views/');
        $view->setVar('moduleName', $moduleName);
    }
    
    /**
     * @param null $path
     * @return mixed
     */
    public function getConfig($path = null)
    {
        if (!$this->config) {
            if (!$path) {
                $path = $this->getReflectionPath() . '/config/config.php';
            }
            if (is_readable($path)) {
                $this->config = include_once $path;
            }
        }
        return $this->config;
    }
    
    /**
     * @return mixed|string
     */
    protected function getReflectionPath()
    {
        if (empty($this->reflectionPath)) {
            $reflectionClass = new \ReflectionClass($this);
            $this->reflectionPath = str_replace('Module.php', '', $reflectionClass->getFileName());
        }
        return $this->reflectionPath;
    }
}