<?php

namespace Amazing79\Simplex\Simplex\Controllers;

use Amazing79\Simplex\Simplex\Traits\HasSession;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * AbstractSessionController
 *
 * Clase base para todos los controladores del proyecto que requieran manejo de sesiones.
 * Provee acceso directo al sistema de sesiones mediante el trait HasSession.
 *
 * Está pensada para ser extendida por controladores concretos, por ejemplo:
 *
 *   class UserController extends AbstractSessionController {
 *       public function perfil() {
 *           $usuario = $this->session()->get('user');
 *       }
 *   }
 */
abstract class AbstractSessionController
{

    use HasSession;
    protected string $basepath;

    /**
     * Constructor genérico del controlador.
     * Puede usarse para inicializar recursos comunes o middleware.
     */
    public function __construct()
    {
        // En caso de que quieras registrar hooks, middlewares o inicializar la sesión aquí
        // Podés acceder a la sesión directamente: $this->session();
        $context = Request::createFromGlobals();
        $this->basepath = $context->getBasePath();
    }

    /**
     * Helper opcional para redirigir a otra ruta.
     *
     * @param string $url URL de destino.
     */
    protected function redirect(string $url): RedirectResponse
    {
        return new RedirectResponse($this->getBasePath($url));
    }

    protected function getBasePath(string $path = ''): string
    {

        return $this->basepath . $path;
    }

}
