<?php

use Silex\Application;

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
$app->get('/what-son', 'Whatson\event::fetchEvents');

/**
 * Run
 */
$app->run();