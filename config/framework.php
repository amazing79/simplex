<?php

use Ignacio\Simplex\Simplex\Listeners\ContentLengthListener;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing;

use DI\Container;

return [
    EventDispatcher::class => function (Container $container) {
        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber(
            new ContentLengthListener()
        );
        return $dispatcher;
    },
    'Routing.Definitions' => function (Container $container) {
        $context = new Routing\RequestContext();
        $context->setHost($container->get('request.globals'));
        return new Routing\Matcher\UrlMatcher($container->get('routes'), $context);
    },
    ArgumentResolver::class => function (Container $container) {
        return new ArgumentResolver();
    },
    ControllerResolver::class => function (Container $container) {
        return new ControllerResolver();
    },
    Ignacio\Simplex\Simplex\Framework::class => function (Container $container) {
        return new Ignacio\Simplex\Simplex\Framework(
            $container->get(EventDispatcher::class),
            $container->get('Routing.Definitions'),
            $container->get(ControllerResolver::class),
            $container->get(ArgumentResolver::class),
        );
    }
];