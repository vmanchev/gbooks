<?php

use Phalcon\Mvc\View;

/**
 * Setting up the view component
 */
$di->set('view', function() {
    $view = new View();

    return $view;
}, true);
/**
 * Register menu builder component
 */
$di->set('menu', function() {
    return new AdminMenu();
});
