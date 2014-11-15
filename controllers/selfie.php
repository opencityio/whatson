<?php

namespace Opencity;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


class Selfie
{
    public function saveImage(Application $app, Request $request)
    {
        $imageData = $request->get('image');

        $connections = $app['mongo'];
        $defaultConnection = $connections['default'];

        $defaultConnection->showDatabases();


        return '';
    }
}