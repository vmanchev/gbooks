<?php

//ini_set('max_execution_time', 30000);
ini_set('display_errors', 'On');
error_reporting(E_ERROR);

try {
    /**
     * Read the configuration
     */
    $config = require __DIR__ . "/../app/config/config.php";

    /**
     * Read auto-loader
     */
    include __DIR__ . "/../app/config/loader.php";

    /**
     * Read services
     */
    include __DIR__ . "/../app/config/services.php";


    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application();
    /**
     * Assign the DI
     */
    $application->setDI($di);

    $modulesConfig = Array();
    $moduleConfig = Array();
    $moduleConfig['className'] = 'Modules\\' . ucfirst($di->get('config')->moduleName) . '\Module';
    $moduleConfig['path'] = __DIR__ . '/../app/modules/' . $di->get('config')->moduleName . '/Module.php';
    $modulesConfig[$di->get('config')->moduleName] = $moduleConfig;
    $application->registerModules($modulesConfig);

    echo $application->handle()->getContent();
} catch (Phalcon\Exception $e) {
    echo $e->getMessage();
} catch (PDOException $e) {
    echo $e->getMessage();
}
