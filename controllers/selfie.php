<?php

namespace Opencity;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


class Selfie
{
    public function saveImage(Application $app, Request $request)
    {
        $imageData = $request->get('image');

        list($type, $data) = explode(';', $imageData);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);

        file_put_contents(__DIR__.'/../selfies/'.mktime().'.png', $data);
        return '';
    }
}