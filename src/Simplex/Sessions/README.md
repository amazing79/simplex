
### CustomSessionHandler

Clase Helper para manejar sesiones en archivos. Cumple con las interfaces nativas:

*  SessionHandlerInterface
*  SessionUpdateTimestampHandlerInterface

Esta clase guarda las sesiones en archivos, funcionando tanto en Windows como en Linux.

Puede adaptarse fácilmente para usar otros backends (Redis, MySQL, etc.).

**🧠 Explicación general del funcionamiento**

**open()**
Se llama cuando PHP inicia una sesión. Se asegura de que el directorio exista y sea escribible.

**close()**
Se ejecuta al cerrar la sesión o al finalizar el script. Ideal para liberar recursos externos (en este caso, no hace falta).

**read($sessionId)**
Devuelve el contenido del archivo de sesión si existe y no está vencido. Si expiró o no existe, devuelve una cadena vacía.

**write($sessionId, $data)**
Escribe los datos serializados en un archivo. Usa flock() para asegurar exclusión mutua, compatible con Windows.

**destroy($sessionId)**
Elimina el archivo asociado a la sesión destruida.

**gc($maxLifetime)**
Elimina sesiones expiradas. PHP llama a este método automáticamente según la configuración de recolección de basura.

**updateTimestamp()**
Actualiza la fecha de modificación del archivo para extender la vida útil de la sesión activa.

**validateId()**
Método opcional pero recomendable para validar que el ID tenga un formato seguro.

**getFilePath()**
Devuelve la ruta completa del archivo de sesión, manejando correctamente los separadores de directorio según el SO.

⚙️ Uso en tu aplicación
```
require_once 'CustomSessionHandler.php';

$handler = new CustomSessionHandler(__DIR__ . '/sessions', 1800); // 30 minutos
session_set_save_handler($handler, true);
session_start();

$_SESSION['usuario'] = 'Ignacio';
echo 'Usuario: ' . $_SESSION['usuario'];
```

✅ Compatibilidad total:

* PHP 7.4, 8.0, 8.1, 8.2, 8.3
* Windows / Linux / macOS
* Modo CLI o Apache / Nginx

### SessionManager y StaticSessionManager

Junto con SessionHandler, se crearon dos clases para facilitar el manejo de sesiones con un formatao orientado a objetos. Estas son:

* SessionManager
* StaticSessionManager

🧠 Explicación de las funciones

| Método              | Descripción                                                                                                    |
|---------------------|----------------------------------------------------------------------------------------------------------------|
| start()             | Inicia la sesión de forma segura y asigna tu CustomSessionHandler. Configura cookies seguras, HTTPS, TTL, etc. |
| set($key, $value)   | Guarda un valor en $_SESSION.                                                                                  |                          
| get($key, $default) | Recupera un valor (o devuelve $default si no existe).                                                          | 
| remove($key)        | Elimina una clave específica.                                                                                  |
| clear()             | Limpia todos los valores de la sesión (sin destruirla).                                                        |
| destroy()           | Destruye completamente la sesión, incluyendo la cookie.                                                        |
| flash($key, $value) | Guarda un valor “temporal” (útil para mensajes tipo "Datos guardados correctamente").                          |
| getFlash($key)      | Recupera el valor “flash” y lo elimina inmediatamente.                                                         |
| isStarted()         | Indica si la sesión ya fue iniciada.                                                                           |

🧠 Diferencias claves entre la versión estática y la versión Singleton

| Característica | Versión estática                                 | Versión Singleton                                    |
|----------------|--------------------------------------------------|------------------------------------------------------|
| Acceso         | SessionManager::set()                            | $session->set()                                      |
| Inicialización | Debe llamarse start()                            | Se inicializa automáticamente al hacer getInstance() |
| Contexto       | No guarda estado                                 | Guarda estado interno y evita reiniciar              | 
| Reutilización  | Puede ser usada en cualquier lugar sin instancia | Ideal para inyección de dependencias o patrones DDD  |
| Multi-entorno  | Más simple para scripts sueltos                  | Más robusta para apps grandes o PSR-4                |

✅ Ventajas de esta versión

* Inicia la sesión automáticamente al obtener la instancia.
* Implementa patrón Singleton correctamente (una única sesión global).
* Encadenamiento fluido ($session->set()->flash()->remove()).
* Más limpia y OO-friendly, ideal si estás usando namespaces o un container DI.
* Sigue siendo 100% compatible con Windows y Linux.
* Reutiliza *CustomSessionHandler* sin modificarlo.