<?php

namespace Opencity;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class Selfie
{
    public function saveImage(Application $app, Request $request)
    {
        $imageData = $request->get('image');

        list($type, $data) = explode(';', $imageData);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);


        header('Access-Control-Allow-Origin: *');

        if ( FALSE == file_put_contents(__DIR__.'/../selfies/'.mktime().'.png', $data) ) {
            return new Response('Bad Request', 400);
        };
        return new Response('Your image - added to the Face of Peterborough!', 200);
    }
}