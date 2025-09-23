<?php

define ('APP_ROOT', dirname(__DIR__));

require_once   APP_ROOT . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Amazing79\Simplex\Simplex\Framework;
use DI\ContainerBuilder;


$dotenv = Dotenv\Dotenv::createImmutable(APP_ROOT);
$dotenv->safeLoad();

$request = Request::createFromGlobals();
$routes = include APP_ROOT .'/config/routes.php';

$builder = new ContainerBuilder();
$container = $builder->addDefinitions(APP_ROOT.'/config/framework.php')
                ->build();
$container->set('request.globals', $request);
$container->set('routes', $routes);

$framework = $container->get(Framework::class);
$response = $framework->handle($request);

$response->send();
