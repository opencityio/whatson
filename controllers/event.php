<?php

namespace Whatson;

use Silex\Application;
use FastFeed\Factory as FFFactory;

class Event
{
    public function fetchEvents(Application $app)
    {

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

            $feedItem = array(
                'title' => $item->getName(),
                'date' => $item->getDate()->format('Y-m-d H:i:s'),
                'category' => array_values(array_intersect(array_values($categories), $allowedCategories)),
                'description' => $item->getIntro()
            );
            $feedItems[] = $feedItem;
        }


        return $app->json($feedItems);
    }
}