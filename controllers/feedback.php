<?php

namespace Opencity;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class Feedback
{
    public function saveData(Application $app, Request $request)
    {
        $feedbackText = $request->get('text');
        $fileName = __DIR__.'/../feedback/data.json';
        $data = file_get_contents($fileName);
        $feedbackData = json_decode($data);
        $feedbackData[] = array("text"=>$feedbackText);
        $feedbackJson = json_encode($feedbackData);
        header('Access-Control-Allow-Origin: *');
        if ( FALSE == file_put_contents($fileName, $feedbackJson) ) {
            $response = new Response('Bad Request', 400);
        }else {
            $response = new Response('Thank you for your feedback!', 200);
        }
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
}
