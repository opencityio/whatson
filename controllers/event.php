<?php

namespace Whatson;

use Silex\Application;
use FastFeed\Factory as FFFactory;
use Desarrolla2\Cache\Cache;
use Desarrolla2\Cache\Adapter\File;


class Event
{
    public function fetchEvents(Application $app)
    {



        $cacheDir = '/tmp';
        $adapter = new File($cacheDir);
        $adapter->setOption('ttl', 300);
        $cache = new Cache($adapter);

        if ( !$cache->has('feed') ) {

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
            $cache->set('feed',$feedItems);
        }

        $feedItems = $cache->get('feed');

        header('Access-Control-Allow-Origin: *');
        return $app->json($feedItems);
    }
}