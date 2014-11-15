<?php

use Silex\Application;

// =======================================================================================================================================
// ================================================================ SETUP ================================================================
// =======================================================================================================================================

/**
 * Include Everything loaded by composer, silex, doctrine etc
 */
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../config/db.php';

require_once __DIR__ . '/../controllers/event.php';



/**
 * Setup Silex and Doctrine
 */
$app = new Silex\Application();
$app->register(new Silex\Provider\DoctrineServiceProvider(), $dbOptions); // Commented out temporarily as we don't know the db details

$app['debug'] = true;


/**
 * Controllers
 */
$app->get('/whatson', 'Whatson\event::fetchEvents');

/**
 * Run
 */
$app->run();