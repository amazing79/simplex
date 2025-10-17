<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseController
{
    protected string $basepath;

    /**
     * Constructor genérico del controlador.
     * Puede usarse para inicializar recursos comunes o middleware.
     */
    public function __construct()
    {
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