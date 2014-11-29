<?php

//Create a group with a common module and controller
$frontend = new \Phalcon\Mvc\Router\Group(array(
    'module' => 'frontend',
    'controller' => 'index',
        ));

// Index =======================================================
// Add a route to the group
$frontend->add('/', array(
    'controller' => 'index',
    'action' => 'index'
))->setName('index_index');

$frontend->add('/search', array(
    'controller' => 'index',
    'action' => 'search'
))->via(array("POST", "GET"))->setName('index_search');

$frontend->add('/status', array(
    'controller' => 'import',
    'action' => 'status'
))->via(array("GET"))->setName('import_status');

$frontend->add('/local-search', array(
    'controller' => 'search',
    'action' => 'local'
))->via(array("GET"))->setName('search_local');

$router->mount($frontend);
