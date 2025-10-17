<?php

namespace Amazing79\Simplex\Simplex\Sessions;

/**
 * SessionManager (versión Singleton)
 *
 * Maneja las sesiones de forma segura usando un CustomSessionHandler.
 * Inicializa automáticamente la sesión al obtener la instancia.
 *
 * Compatible con PHP 7.4+ y 8.x (Windows / Linux).
 */

class SessionManager
{
    /** @var SessionManager|null Instancia única */
    private static ?SessionManager $instance = null;

    /** @var bool Indica si la sesión ya fue iniciada */
    private bool $started = false;

    /** @var CustomSessionHandler */
    private CustomSessionHandler $handler;

    /**
     * Constructor privado (patrón Singleton)
     */
    private function __construct(string $path, int $ttl, array $options = [])
    {
        $this->initialize($path, $ttl, $options);
    }

    /**
     * Devuelve la instancia única del SessionManager.
     * Si no existe, la crea e inicia la sesión automáticamente.
     *
     * @param string $path Directorio de sesión.
     * @param int $ttl Tiempo de vida.
     * @param array $options Opciones de configuración.
     * @return SessionManager
     */
    public static function getInstance(
        string $path = '',
        int    $ttl = 1800,
        array  $options = []
    ): SessionManager
    {
        if (self::$instance === null) {
            self::$instance = new self($path, $ttl, $options);
        }

        return self::$instance;
    }

    /**
     * Inicializa la sesión (solo se llama una vez).
     */
    private function initialize(string $path, int $ttl, array $options = []): void
    {
        if ($this->started) {
            return;
        }

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

        $options = array_merge($defaults, $options);

        foreach ($options as $key => $value) {
            ini_set("session.$key", (string)$value);
        }

        session_name($_ENV['SESSION_NAME'] ?? 'Simplex');
        session_set_cookie_params(
            $options['cookie_lifetime'],
            '/',
            '',
            $options['cookie_secure'],
            true
        );

        // Asignamos el handler personalizado
        $this->handler = new CustomSessionHandler($path, $ttl);
        session_set_save_handler($this->handler, true);

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->started = true;
    }

    /**
     * Guarda un valor en la sesión.
     */
    public function set(string $key, $value): self
    {
        $_SESSION[$key] = $value;
        return $this;
    }

    /**
     * Obtiene un valor de la sesión.
     */
    public function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Elimina una clave.
     */
    public function remove(string $key): self
    {
        unset($_SESSION[$key]);
        return $this;
    }

    /**
     * Limpia todos los datos de la sesión (sin destruirla).
     */
    public function clear(): self
    {
        $_SESSION = [];
        return $this;
    }

    /**
     * Destruye completamente la sesión (incluye la cookie).
     */
    public function destroy(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION = [];

            if (ini_get('session.use_cookies')) {
                $params = session_get_cookie_params();
                setcookie(
                    session_name(),
                    '',
                    time() - 42000,
                    $params['path'],
                    $params['domain'],
                    $params['secure'],
                    $params['httponly']
                );
            }

            session_destroy();
        }

        $this->started = false;
        self::$instance = null;
    }

    /**
     * Guarda un valor "flash" (una sola lectura).
     */
    public function flash(string $key, $value): self
    {
        $_SESSION['_flash'][$key] = $value;
        return $this;
    }

    /**
     * Obtiene y elimina un valor flash.
     */
    public function getFlash(string $key, $default = null)
    {
        if (!isset($_SESSION['_flash'][$key])) {
            return $default;
        }

        $value = $_SESSION['_flash'][$key];
        unset($_SESSION['_flash'][$key]);
        return $value;
    }

    /**
     * Verifica si la sesión está activa.
     */
    public function isStarted(): bool
    {
        return $this->started && session_status() === PHP_SESSION_ACTIVE;
    }

    /**
     * Devuelve el ID actual de sesión.
     */
    public function id(): string
    {
        return session_id();
    }

    /**
     * Previene la clonación (propio del patrón Singleton).
     */
    private function __clone()
    {
    }

    /**
     * Previene la deserialización del objeto.
     */
    public function __wakeup()
    {
        throw new \Exception("No se puede deserializar la instancia de SessionManager");
    }
}
