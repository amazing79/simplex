<?php
/**
 * @var \Amazing79\Simplex\Simplex\Renders\HtmlRender $this
 */
$back = $url ?? $_ENV['APP_PATH'] ?? '/';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página no encontrada</title>
    <style>
        body {
            background: #1e1e2f;
            color: #fff;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            overflow: hidden;
        }

        h1 {
            font-size: 8rem;
            margin: 0;
            color: #ff6b6b;
            animation: bounce 1.5s infinite;
        }

        h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        p {
            max-width: 400px;
            margin-bottom: 30px;
            font-size: 1rem;
        }

        a {
            background: #ff6b6b;
            color: #fff;
            padding: 12px 24px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }

        a:hover {
            background: #ff4757;
        }

        .astronaut {
            width: 200px;
            margin-top: 20px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>
<body>
<h1>404</h1>
<h2>¡Oops! Te perdiste en el espacio 🚀</h2>
<p>
    Parece que esta página no existe...
    Pero tranquilo, hasta los astronautas se pierden de vez en cuando.
</p>
<p id="joke">Cargando chiste...</p>
<a href="<?= $back ?>">Volver al inicio</a>
<img class="astronaut" src="<?= $this->includeAsset('/images/astronauta.png')?>" alt="Astronauta perdido">
</body>
<script>
    const jokes = [
        "Error 404: El café no se encontró ☕",
        "Esta página se escondió mejor que tus medias en la lavadora 🧦",
        "404: El servidor dijo 'yo no fui' 😅",
        "Ups... te perdiste más que GPS sin señal 📡",
        "Parece que esta página se fue de vacaciones 🏖️",
        "Error 404: Tu sentido de la orientación está en mantenimiento 🔧",
        "No es culpa tuya, es culpa del internet… probablemente 🤔"
    ];

    const jokeElement = document.getElementById("joke");
    const randomJoke = jokes[Math.floor(Math.random() * jokes.length)];
    jokeElement.textContent = randomJoke;
</script>
</html>

