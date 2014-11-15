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



/**
 * Setup Silex
 */
$app = new Silex\Application();
$app['debug'] = true;


/**
 * Controllers
 */
$app->get('/whats-on', 'Opencity\event::fetchEvents');

/**
 * Run
 */
$app->run();