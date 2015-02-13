<?php

use Silex\Application;
use Mongo\Silex\Provider\MongoServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


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

//handling CORS preflight request
$app->before(function (Request $request) {
    if ($request->getMethod() === "OPTIONS") {
        $response = new Response();
        $response->headers->set("Access-Control-Allow-Methods","GET,POST,PUT,DELETE,OPTIONS");
        $response->headers->set("Access-Control-Allow-Origin",'*');
        $response->headers->set("Access-Control-Allow-Headers","Content-Type");
        $response->setStatusCode(200);
        return $response->send();
    }
}, Application::EARLY_EVENT);

//handling CORS respons with right headers
$app->after(function (Request $request, Response $response) {
    $response->headers->set("Access-Control-Allow-Methods","GET,POST,PUT,DELETE,OPTIONS");
    $response->headers->set("Access-Control-Allow-Origin","*");
});



//$app->register(new MongoServiceProvider, array(
//    'mongo.connections' => array(
//        'default' => array(
//            'server' => "mongodb://localhost:27017",
//            'options' => array("connect" => true)
//        )
//    ),
//));

$app['debug'] = true;


/**
 * Controllers
 */

// accept OPTIONS requests for angular
//$app->match("{url}",function($url) use ($app){
//    return "OK";
//})->assert('url', '.*')->method("OPTIONS");

$app->get('/whats-on', 'Opencity\event::fetchEvents');
$app->post('/selfie', 'Opencity\selfie::saveImage');
$app->post('/feedback', 'Opencity\feedback::saveData');

/**
 * Run
 */

header_remove('Access-Control-Allow-Origin');
header('Access-Control-Allow-Origin: *');
$app->run();