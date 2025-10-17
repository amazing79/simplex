### AbstractSessionController 

Clase base para controladores que incorpora el trait HasSession, preparada para que cualquier controlador pueda heredar de ella y tener acceso directo al manejo de sesiones y otras utilidades si más adelante querés sumarlas (logging, respuestas HTTP, helpers, etc.).

🧩 Ejemplo de uso
```
<?php
namespace App\Controllers;

use Amazing79\Simplex\Simplex\Controllers\AbstractSessionController;

class UserController extends AbstractSessionController
{
    public function login(string $user, string $pass): void
    {
        if ($user === 'ignacio' && $pass === '1234') {
            $this->session()
                 ->set('user', $user)
                 ->flash('msg', 'Bienvenido de nuevo, Ignacio!');

            $this->redirect('/perfil');
        } else {
            $this->jsonResponse(['error' => 'Credenciales inválidas'], 401);
        }
    }

    public function perfil(): void
    {
        $user = $this->session()->get('user', 'Invitado');
        $msg = $this->session()->getFlash('msg');

        echo "<h2>Perfil de usuario</h2>";
        echo "<p>Usuario: {$user}</p>";
        if ($msg) {
            echo "<p><em>{$msg}</em></p>";
        }
    }
}
```

🚀 Ventajas de esta arquitectura

✅ Extensible — los controladores heredan automáticamente todo lo de AbstractSessionController.

✅ Centralizado — si querés agregar logs, ACL, response builders, etc., lo hacés una sola vez.

✅ Limpio y coherente — cada controlador accede a $this->session() sin importar si el entorno es Windows o Linux.

✅ Futuro-proof — el handler, el trait y la base están listos para integrarse en un mini framework o PSR-15 middleware stack.