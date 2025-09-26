<?php

use Amazing79\Simplex\Simplex\Listeners\ContentLengthListener;
use Amazing79\Simplex\Simplex\Listeners\NotFoundListener;
use Symfony\Component\EventDispatcher\EventDispatcher;

return [
   EventDispatcher::class => function () {
        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber( new ContentLengthListener());
        $dispatcher->addSubscriber( new NotFoundListener());
        return $dispatcher;
    }
];