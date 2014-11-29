<?php

// get dbParameters
$dbParameters = require_once __DIR__ . "/".getenv('APPLICATION_ENV')."/db.php";

return new \Phalcon\Config(Array(
    'database' => $dbParameters['db'],
    'application' => Array(
        'controllersDir' => __DIR__ . '/../../app/controllers/',
        'modelsDir' => __DIR__ . '/../../app/models/',
        'viewsDir' => __DIR__ . '/../../app/views/',
        'libraryDir' => __DIR__ . '/../../app/library/',
        'baseUri' => '/',
        'siteName' => 'cars'
    ),
    'session' => Array(
        'lifetime' => 600
    ),
    'additionalFiles' => Array(
        'documentsDir' => __DIR__ . '/../../documents/',
    ),
    'gbooksapi' => 'https://www.googleapis.com/books/v1/volumes' 
        ));
