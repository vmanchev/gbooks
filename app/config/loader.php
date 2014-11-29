<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$namespaces['Gbooks\Models'] = realpath(__DIR__ . '/../models/');

$string = explode("/", $_SERVER['REQUEST_URI']);
if (in_array('admin', $string)) {
    $config->moduleName = 'admin';
} else {
    $config->moduleName = 'frontend';
}

$namespaces['Modules\\' . ucfirst($config->moduleName) . '\Controllers'] = realpath(__DIR__ . '/../modules/' . $config->moduleName . '/controllers/');
$namespaces['Modules\\' . ucfirst($config->moduleName) . '\Plugins'] = realpath(__DIR__ . '/../modules/' . $config->moduleName . '/plugins/');
$namespaces['Modules\\' . ucfirst($config->moduleName) . '\Forms'] = realpath(__DIR__ . '/../modules/' . $config->moduleName . '/forms/');

$loader->registerNamespaces($namespaces);

$loader->registerDirs(
        array(
            $config->application->controllersDir,
            $config->application->modelsDir,
            $config->application->libraryDir
        )
)->register();
