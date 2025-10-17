<?php

namespace Amazing79\Simplex\Simplex\Sessions;

use SessionHandlerInterface;
use SessionUpdateTimestampHandlerInterface;

/**
 * CustomSessionHandler
 *
 * Implementación personalizada de un manejador de sesiones compatible con PHP 7.4+ y 8.x.
 * Cumple con las interfaces nativas:
 *  - SessionHandlerInterface
 *  - SessionUpdateTimestampHandlerInterface
 *
 * Esta clase guarda las sesiones en archivos, funcionando tanto en Windows como en Linux.
 * Puede adaptarse fácilmente para usar otros backends (Redis, MySQL, etc.).
 */
class CustomSessionHandler implements SessionHandlerInterface, SessionUpdateTimestampHandlerInterface
{
    /** @var string Directorio donde se guardan los archivos de sesión */
    protected string $savePath;

    /** @var int Tiempo de vida (TTL) de la sesión en segundos */
    protected int $ttl;

    /**
     * Constructor de la clase.
     *
     * @param string $savePath Directorio donde se guardan los archivos de sesión.
     * @param int    $ttl      Tiempo de vida de la sesión en segundos (por defecto: 1440 = 24 minutos).
     */
    public function __construct(string $savePath = '', int $ttl = 1440)
    {
        // Si no se pasa un path, se usa el sistema temporal del OS
        $this->savePath = $savePath ?: sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'sessions';
        $this->ttl = $ttl;
    }

    /**
     * Se ejecuta al iniciar la sesión.
     * PHP llama a este método automáticamente.
     *
     * @param string $path Ruta donde PHP espera guardar los datos (no se usa en este caso).
     * @param string $name Nombre de la sesión.
     * @return bool Devuelve true si se pudo abrir correctamente.
     */
    public function open(string $path, string $name): bool
    {
        if (!is_dir($this->savePath)) {
            // Se crea el directorio si no existe
            if (!@mkdir($this->savePath, 0777, true) && !is_dir($this->savePath)) {
                return false;
            }
        }

        return is_writable($this->savePath);
    }

    /**
     * Se ejecuta al cerrar la sesión.
     * Puede usarse para cerrar conexiones a bases de datos u otros recursos.
     *
     * @return bool
     */
    public function close(): bool
    {
        // En este caso no hay recursos externos que cerrar
        return true;
    }

    /**
     * Lee los datos de sesión asociados a un ID dado.
     * Si el archivo no existe o expiró, devuelve una cadena vacía.
     *
     * @param string $id ID de la sesión.
     * @return string Datos de la sesión (serializados por PHP) o cadena vacía si no hay datos.
     */
    public function read(string $id): string
    {
        $file = $this->getFilePath($id);

        if (!file_exists($file)) {
            return '';
        }

        // Comprobamos expiración manualmente
        if (filemtime($file) + $this->ttl < time()) {
            @unlink($file);
            return '';
        }

        $data = @file_get_contents($file);
        return $data === false ? '' : $data;
    }

    /**
     * Escribe los datos de la sesión al archivo correspondiente.
     *
     * @param string $id ID de la sesión.
     * @param string $data Datos de la sesión serializados.
     * @return bool true en caso de éxito, false si ocurre un error.
     */
    public function write(string $id, string $data): bool
    {
        $file = $this->getFilePath($id);

        // Uso de fopen/fwrite/touch en lugar de file_put_contents para compatibilidad con Windows
        if (($handle = @fopen($file, 'c+b')) === false) {
            return false;
        }

        // Bloqueo exclusivo mientras se escribe (funciona en Windows también)
        if (!flock($handle, LOCK_EX)) {
            fclose($handle);
            return false;
        }

        // Limpiar contenido previo y escribir el nuevo
        ftruncate($handle, 0);
        fwrite($handle, $data);
        fflush($handle);

        // Liberar bloqueo y cerrar
        flock($handle, LOCK_UN);
        fclose($handle);

        return true;
    }

    /**
     * Destruye la sesión eliminando su archivo.
     *
     * @param string $id ID de la sesión.
     * @return bool true si se eliminó correctamente, false en caso contrario.
     */
    public function destroy(string $id): bool
    {
        $file = $this->getFilePath($id);
        if (file_exists($file)) {
            @unlink($file);
        }
        return true;
    }

    /**
     * Garbage collector.
     * Se encarga de eliminar las sesiones expiradas.
     * PHP lo llama automáticamente según la configuración de `session.gc_probability` y `session.gc_divisor`.
     *
     * @param int $max_lifetime Tiempo máximo de vida (pasado por PHP.ini, puede diferir de $this->ttl)
     * @return int|false Número de archivos eliminados o false si falla.
     */
    public function gc(int $max_lifetime): int|false
    {
        $deleted = 0;

        foreach (glob($this->savePath . DIRECTORY_SEPARATOR . 'sess_*') as $file) {
            if (is_file($file) && filemtime($file) + $this->ttl < time()) {
                if (@unlink($file)) {
                    $deleted++;
                }
            }
        }

        return $deleted;
    }

    /**
     * Actualiza la marca de tiempo del archivo de sesión.
     * PHP lo llama para mantener viva una sesión activa sin reescribir datos.
     *
     * @param string $id ID de la sesión.
     * @param string $data Datos actuales (no usados aquí).
     * @return bool true si se actualizó correctamente.
     */
    public function updateTimestamp(string $id, string $data = ''): bool
    {
        $file = $this->getFilePath($id);
        if (file_exists($file)) {
            return @touch($file);
        }

        return false;
    }

    /**
     * (Opcional) Valida que el ID de sesión tenga un formato seguro.
     * Evita inyecciones o ataques con IDs malformados.
     *
     * @param string $id ID a validar.
     * @return bool true si es válido, false si no.
     */
    public function validateId(string $id): bool
    {
        return preg_match('/^[a-zA-Z0-9,-]{22,}$/', $id) === 1;
    }

    /**
     * Devuelve la ruta completa del archivo asociado a un ID de sesión.
     *
     * @param string $id
     * @return string Ruta completa del archivo.
     */
    protected function getFilePath(string $id): string
    {
        // DIRECTORY_SEPARATOR maneja correctamente "\" en Windows y "/" en Linux
        return $this->savePath . DIRECTORY_SEPARATOR . 'sess_' . $id;
    }
}
