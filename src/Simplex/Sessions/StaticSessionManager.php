<?php

namespace Amazing79\Simplex\Simplex\Sessions;
/**
 * SessionManager - Static verion
 *
 * Clase de ayuda para inicializar, manejar y simplificar el uso de sesiones.
 * Usa un handler personalizado (CustomSessionHandler).
 *
 * Funcionalidades:
 *  - Iniciar sesión de forma segura.
 *  - Guardar, obtener y eliminar datos.
 *  - Limpiar toda la sesión.
 *  - Manejar valores "flash" (se leen una sola vez).
 */
class StaticSessionManager
{

    /** @var bool Indica si la sesión ya fue iniciada */
    protected static bool $started = false;

    /** @var CustomSessionHandler | null */
    protected static ?CustomSessionHandler $handler = null;

    /**
     * Inicia la sesión con configuraciones seguras.
     *
     * @param string $path Directorio donde se guardarán los archivos de sesión.
     * @param int $ttl Tiempo de vida en segundos.
     * @param array $options Opciones adicionales de configuración.
     */
    public static function start(string $path = '', int $ttl = 1800, array $options = []): void
    {
        if (self::$started) {
            return;
        }

        // Configuración segura por defecto
        $defaults = [
            'cookie_lifetime' => 0,
            'cookie_httponly' => true,
            'cookie_secure' => isset($_SERVER['HTTPS']),
            'use_strict_mode' => true,
            'use_only_cookies' => true,
            'gc_maxlifetime' => $ttl,
            'sid_length' => 48,
            'sid_bits_per_character' => 6,
        ];

        session_name('APPSESSID');
        session_set_cookie_params($defaults['cookie_lifetime'], '/', '', $defaults['cookie_secure'], true);

        foreach ($defaults as $key => $value) {
            ini_set("session.$key", (string)$value);
        }

        // Asignamos el handler personalizado
        self::$handler = new CustomSessionHandler($path, $ttl);
        session_set_save_handler(self::$handler, true);

        // Iniciamos la sesión
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
            self::$started = true;
        }
    }

    /**
     * Guarda un valor en la sesión.
     *
     * @param string $key
     * @param mixed $value
     */
    public static function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Obtiene un valor de la sesión.
     *
     * @param string $key
     * @param mixed $default Valor por defecto si no existe.
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Elimina una clave específica de la sesión.
     *
     * @param string $key
     */
    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Limpia todos los datos de la sesión.
     */
    public static function clear(): void
    {
        $_SESSION = [];
    }

    /**
     * Destruye completamente la sesión (incluyendo la cookie).
     */
    public static function destroy(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            // Limpiar datos
            $_SESSION = [];

            // Borrar cookie
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
            }

            session_destroy();
            self::$started = false;
        }
    }

    /**
     * Guarda un valor "flash" (se lee una sola vez).
     *
     * Ejemplo:
     *   SessionManager::flash('msg', 'Guardado correctamente');
     *   echo SessionManager::getFlash('msg'); // muestra y elimina
     *
     * @param string $key
     * @param mixed $value
     */
    public static function flash(string $key, $value): void
    {
        $_SESSION['_flash'][$key] = $value;
    }

    /**
     * Obtiene y elimina un valor "flash".
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function getFlash(string $key, $default = null)
    {
        if (!isset($_SESSION['_flash'][$key])) {
            return $default;
        }

        $value = $_SESSION['_flash'][$key];
        unset($_SESSION['_flash'][$key]);
        return $value;
    }

    /**
     * Verifica si la sesión está iniciada.
     *
     * @return bool
     */
    public static function isStarted(): bool
    {
        return self::$started && session_status() === PHP_SESSION_ACTIVE;
    }
}
