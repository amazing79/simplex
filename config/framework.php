<?php

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ContainerControllerResolver;
//use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing;
use DI\Container;

return [
    'Routing.Definitions' => function (Container $container) {
        $context = new Routing\RequestContext();
        return new Routing\Matcher\UrlMatcher($container->get('routes'), $context);
    },
    ArgumentResolver::class => function () {
        return new ArgumentResolver();
    },
    ContainerControllerResolver::class => function (Container $container) {
        return  new ContainerControllerResolver($container);
    },
    Amazing79\Simplex\Simplex\Framework::class => function (Container $container) {
        return new Amazing79\Simplex\Simplex\Framework(
            $container->get(EventDispatcher::class),
            $container->get('Routing.Definitions'),
            $container->get(ContainerControllerResolver::class),
            $container->get(ArgumentResolver::class),
        );
    }
];