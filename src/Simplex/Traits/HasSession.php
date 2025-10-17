<?php

namespace Amazing79\Simplex\Simplex\Traits;

use Amazing79\Simplex\Simplex\Sessions\SessionManager;
trait HasSession
{
    /**
     * Devuelve la instancia activa de SessionManager.
     * Si no existe, la crea automáticamente.
     *
     * @return SessionManager
     */
    protected function session(): SessionManager
    {
        return SessionManager::getInstance(SESSION_ROOT);
    }
}

