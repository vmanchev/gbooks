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


$router->mount($frontend);
