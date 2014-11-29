<?php

//Create a group with a common module and controller
$admin = new \Phalcon\Mvc\Router\Group(array(
    'module' => 'admin',
    'controller' => 'index',
        ));

//All the routes start with /admin
$admin->setPrefix('/admin');

// Index =======================================================
// Add a route to the group
$admin->add('/', array(
    'controller' => 'index',
    'action' => 'index'
))->setName('admin_index_index');

$admin->add('/login', array(
    'controller' => 'index',
    'action' => 'login'
))->via(array("POST", "GET"))->setName('admin_index_login');

$admin->add('/logout', array(
    'controller' => 'index',
    'action' => 'logout'
))->via(array("GET"))->setName('admin_index_logout');

$router->mount($admin);
