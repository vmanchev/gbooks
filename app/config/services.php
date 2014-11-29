<?php

use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Model\Manager;
use Json\Responce as JsonResponce;
use Broadway\Engine\Channels;
use Broadway\Engine\Suppliers;
use Broadway\Engine\ArrivalAirports;
use Phalcon\Mvc\View;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set('url', function() use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});

$domainName = $di->getRequest()->getHttpHost();


$di->set('view', function() {
    $view = new View();

    return $view;
}, true);

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function () use ($config) {
    $dbConfig = array(
        "host" => $config->database->host,
        "username" => $config->database->username,
        "password" => $config->database->password,
        "dbname" => $config->database->name,
        "charset" => 'utf8'
    );

    if (isset($config->database->unix_socket)) {
        $dbConfig['unix_socket'] = $config->database->unix_socket;
    }

    $dbAdapter = new DbAdapter($dbConfig);
    //$dbAdapter->execute('SET NAMES utf8');

    return $dbAdapter;
});

 /**
 * Start the session the first time some component request the session service
 */
$di->set('session', function () use ($config) {
    $session = new SessionAdapter($config->session->toArray());
    if (!isset($_SESSION)) {
        $session->start();
    }

    return $session;
});

$di->set('cookies', function() {
    $cookies = new Phalcon\Http\Response\Cookies();
    $cookies->useEncryption(false);
    return $cookies;
});


/**
 * 
 */
$di->set('dispatcher', function () use ($di) {
    $eventsManager = $di->getShared('eventsManager');
    $dispatcher = new Phalcon\Mvc\Dispatcher();
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
});

$di->set('router', function () use ($di) {
    $router = new Router();
    $router->removeExtraSlashes(true);
    $router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);

    $router->setDefaultModule($di->get('config')->moduleName);

    $defaults = array(
        'module' => $di->get('config')->moduleName,
        'controller' => 'index',
        'action' => 'index',
    );

    $defaultAction = array(
        'module' => $di->get('config')->moduleName,
        'controller' => 1,
        'action' => 'index',
    );

    $controllerAction = array(
        'module' => $di->get('config')->moduleName,
        'controller' => 1,
        'action' => 2,
    );

    $router->add('/' . $di->get('config')->moduleName, $defaults);
    $router->add('/' . $di->get('config')->moduleName . '/:controller', $defaultAction);
    $router->add('/' . $di->get('config')->moduleName . '/:controller/:action', $controllerAction);
    $router->add('/' . $di->get('config')->moduleName . '/:controller/:action/:params', array(
        'module' => $di->get('config')->moduleName,
        'controller' => 1,
        'action' => 2,
        'params' => 3
    ));

    $filePath = __DIR__ . '/../modules/' . $di->get('config')->moduleName . '/config/routes.php';
    if (is_readable($filePath)) {
        include_once $filePath;
    }

    return $router;
});

$di->set('response', function() {
    return new \Phalcon\Http\Response();
});


$di->setShared('config', $config);

$di->setShared('baseUri', function () use ($config) {
    $baseUri = $config->application->baseUri;
    if (strpos($baseUri, 'http://')) {
        $baseUri = str_replace('http://', '', $baseUri);
    }
    if (strpos($baseUri, 'https://')) {
        $baseUri = str_replace('https://', '', $baseUri);
    }
    return 'http://' . trim($baseUri, '/');
});

$di->set('modelManager', function() {
    return new Manager();
});


/**
 * Register the flash service with custom CSS classes
 */
$di->set('flash', function() {
    return new Phalcon\Flash\Direct(array(
        'error' => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice' => 'alert alert-info',
        'warning' => 'alert alert-warning',
    ));
});

/**
 * Register recordset finder
 */
$di->set('recordset', function() {
    return new Recordset();
});

$di->set('settings', function() {
    return new Settings();
});

$di->set('jsonResponce', function() {
    return new JsonResponce();
});

$di->set('channels', function() {
    return new Channels();
});

$di->set('suppliers', function() {
    return new Suppliers();
});

$di->set('arrivalAirports', function() {
    return new ArrivalAirports();
});

/**
 * Utils
 */
$di->set('utils', function() {
    return new Utils();
});

// Module services
$filePath = __DIR__ . '/../modules/' . $config->moduleName . '/config/services.php';
if (is_readable($filePath)) {
    include_once $filePath;
}
