<?php

namespace Amazing79\Simplex\Simplex\Listeners;

use Amazing79\Simplex\Simplex\Events\KernelEvents;
use Amazing79\Simplex\Simplex\Events\ResponseEvent;
use Amazing79\Simplex\Simplex\Render;
use Amazing79\Simplex\Simplex\Renders\HtmlRender;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NotFoundListener implements EventSubscriberInterface
{
    public function onNotFound(ResponseEvent $event):void
    {
        $response = $event->getResponse();
        $render = new Render(new HtmlRender());
        $response->setContent($render->render('error/index')->getContent());
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::NotFound->value => ['onNotFound']];
    }
}