<?php

namespace Whatson;

use Silex\Application;
use FastFeed\Factory as FFFactory;
use Gregwar\Cache\Cache;


class Event
{
    public function fetchEvents(Application $app)
    {

//        $cache = new Cache;
//        $cache->setCacheDirectory('cache'); // This is the default
//
//// If the cache exists, this will return it, else, the closure will be called
//// to create this image
//        $data = $cache->getOrCreate('red-square.png', array(), function($filename) {
//            $i = imagecreatetruecolor(100, 100);
//            imagefill($i, 0, 0, 0xff0000);
//            imagepng($i, $filename);
//        });
//
//        header('Content-type: image/png');
//        echo $data;

        $allowedCategories = array(
            "Dance", "Art", "Sport", "Music", "Theatre", "Event"
        );

        $fastFeed = FFFactory::create();
        $fastFeed->addFeed('default', 'http://www.idea1.org.uk/event/?feed=rss');
        $fastFeed->addFeed('default', 'http://www.peterboroughtoday.co.uk/rss/cmlink/1.5073523');
        $fastFeed->addFeed('default', 'http://www.peterborough-cathedral.org.uk/feed_events.xml');
        $fastFeed->addFeed('default', 'http://www.peterborougharena.com/events-overview/feed/');
        $items = $fastFeed->fetch('default');
        $feedItems = array();
        foreach ($items as $item) {
            $categories = $item->getTags();
            $filteredCats = array_values(array_intersect(array_values($categories), $allowedCategories));

            $feedItem = array(
                'title' => $item->getName(),
                'date' => $item->getDate()->format('Y-m-d H:i:s'),
                'category' => count($filteredCats) > 0 ? $filteredCats[0] : '',
                'description' => $item->getIntro()
            );
            $feedItems[] = $feedItem;
        }

        header('Access-Control-Allow-Origin: *');
        return $app->json($feedItems);
    }
}