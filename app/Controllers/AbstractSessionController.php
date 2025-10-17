<?php

namespace App\Controllers;

use Amazing79\Simplex\Simplex\Traits\HasSession;

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
abstract class AbstractSessionController extends BaseController
{
    use HasSession;

    public function __construct()
    {
        // En caso de que quieras registrar hooks, middlewares o inicializar la sesión aquí
        // Podés acceder a la sesión directamente: $this->session();
        parent::__construct();
    }
}
