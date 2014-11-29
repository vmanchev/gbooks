<?php

// get dbParameters
$dbParameters = require_once __DIR__ . "/development/db.php";

return new \Phalcon\Config(Array(
    'database' => $dbParameters['db'],
    'databaseLogger' => $dbParameters['dbLogger'],
    'application' => Array(
        'controllersDir' => __DIR__ . '/../../app/controllers/',
        'modelsDir' => __DIR__ . '/../../app/models/',
        'viewsDir' => __DIR__ . '/../../app/views/',
        'pluginsDir' => __DIR__ . '/../../app/plugins/',
        'libraryDir' => __DIR__ . '/../../app/library/',
        'data' => __DIR__ . '/../../_projectfiles/data/',
        'baseUri' => '/',
        'siteName' => 'cars'
    ),
    'session' => Array(
        'lifetime' => 600
    ),
    'additionalFiles' => Array(
        'documentsDir' => __DIR__ . '/../../documents/',
    ),
        ));
