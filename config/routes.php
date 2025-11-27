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
//controller for welcome page. For testing propose
//Deleting this cause tests fails.
$routes->add('welcome.welcome', new Routing\Route('/welcome', [
    '_controller' => 'App\Controllers\Welcome\WelcomeController::welcome',
]));
/** IndexController como punto de acceso a la App. También muestra la página de bienvenida
* Se proveen a modo de ejemplo, pero se pueden editar a gusto, ya que no rompe los tests de fábrica
 *
 */
$routes->add('index', new Routing\Route('/', [
    '_controller' => 'App\Controllers\Index\IndexController::index',
]));

$routes->add('index.layout', new Routing\Route('/layout', [
    '_controller' => 'App\Controllers\Index\IndexController::layout',
]));
return $routes;
