<?php

namespace Amazing79\Simplex\Simplex\Listeners;

use Amazing79\Simplex\Simplex\Events\ResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ContentLengthListener implements EventSubscriberInterface
{
    public function onResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();
        $headers = $response->headers;

        if (!$headers->has('Content-Length') && !$headers->has('Transfer-Encoding')) {
            $headers->set('Content-Length', strlen($response->getContent()));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return ['response' => ['onResponse', -255]];
    }
}