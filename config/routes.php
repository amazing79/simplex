<?php

use Symfony\Component\Routing;

/**
 * Configurar las rutas de la app. Por defecto tenemos / que es el equivalente a mostrar index.
 */
$routes = new Routing\RouteCollection();
/**
 * algunos  ejemplos

    $routes->add('hello', new Routing\Route('/hello/{name}', ['name' => 'World']));
    $routes->add('bye', new Routing\Route('/bye/{parameter}/{parameter2}', [
 *      'parameter' => default_value,
 *      'parameter2' => default_value
 *      '_controller' => function(Request $request){
 *          return new Response();
 *      }
 * ]));
*/
$routes->add('index', new Routing\Route('/', [
    '_controller' => 'App\Controllers\Index\IndexController::index',
]));

$routes->add('index.layout', new Routing\Route('/layout', [
    '_controller' => 'App\Controllers\Index\IndexController::layout',
]));
return $routes;
