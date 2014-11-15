<?php

use Silex\Application;
use Mongo\Silex\Provider\MongoServiceProvider;



// =======================================================================================================================================
// ================================================================ SETUP ================================================================
// =======================================================================================================================================

/**
 * Include Everything loaded by composer, silex
 */
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__ . '/../controllers/event.php';
require_once __DIR__ . '/../controllers/selfie.php';
require_once __DIR__ . '/../controllers/feedback.php';



/**
 * Setup Silex
 */
$app = new Silex\Application();

$app->register(new MongoServiceProvider, array(
    'mongo.connections' => array(
        'default' => array(
            'server' => "mongodb://localhost:27017",
            'options' => array("connect" => true)
        )
    ),
));

$app['debug'] = true;


/**
 * Controllers
 */
$app->get('/whats-on', 'Opencity\event::fetchEvents');
$app->post('/selfie', 'Opencity\selfie::saveImage');
$app->post('/feedback', 'Opencity\feedback::saveData');

/**
 * Run
 */
$app->run();