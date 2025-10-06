<?php
/**
 * @var \Amazing79\Simplex\Simplex\Renders\HtmlRender $this
 */
// $url es un valor que le podemos enviar por el controlador.
$urlTuto = $url ?? 'https://symfony.com/doc/current/create_framework/index.html';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simplex Framework</title>
    <link href="<?= $this->includeAsset('/css/simplex.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= $this->includeAsset('/favicon.ico') ?>" rel="icon">
</head>
<body>

<!-- Hero Section -->
<section class="hero">
    <h1>¡Bienvenido a Simplex!</h1>
    <h1>El framework que no pediste ni necesitabas (pero acá está)</h1>
    <h2>Inspirado en el tutorial de Symfony <i><a href="<?= $urlTuto?>" class="link_text" target="_blank">"Create your own PHP Framework"</a> </i></h2>
    <a href="#contenido" class="cta-btn">🚀 Empezar ahora</a>
</section>

<!-- Main Content -->
<main id="contenido" class="container">
    <section class="reveal">
        <h2>Para empezar a programar</h2>
        <p>Si querés empezar a programar, acordate de configurar lo siguiente (siempre y cuando lo necesites):</p>
        <ul>
            <li>Modelos</li>
            <li>Base de datos</li>
            <li>Otras configuraciones necesarias</li>
        </ul>
        <p>
            Esto despu&acute;s lo agregas en los injectores de dependencias (dentro de config, hay algunos ejemplos) y ¡¡guala!!.
            Record&aacute; agregar estas configuraciones desde tu punto de acceso a la app, es decir
            <strong>public/index.php</strong>.
        </p>
    </section>

    <section class="reveal">
        <h2>Personalización</h2>
        <section style="text-align: justify;">
            <p>
                Recordá que este framework es personalizable, por lo cual si querés
                agregarle cosas al framework, hacelo a tu gusto. Podr&aacute;s encontrar el c&oacute;digo dentro del directorio <strong>src/</strong>.
                Todo lo demás, colocalo dentro de <strong>app/</strong>.
            </p>
            <p>
                El funcionamiento es similar a otros frameworks. Aunque en el tutorial se segu&iacute;a un enfoque orientado
                a <strong>Response/Request</strong>, se lo llevo a un enfoque MVC.
                Para entender un poco como funciona, se agreg&oacute; un controller (IndexController) como tambi&eacute;n algunas
                plantillas de ejemplo (welcome, layout y error). Estas editar a gusto.
            </p>
            <p>
                Las plantillas son html + php puro. Para facilitar la mantenibilidad de la estructura del sitio, se provee un layout de ejemplo para ver como simplificar
                el c&oacute;digo de nuestras vistas. Por lo tanto, para renderizar html contaremos con dos estrategias (HtmlRender y HtmlLayoutRender).
            </p>
            <ul>
                <li>
                    En el primero podremos incluir en la plantilla todo el html del documento.
                </li>
                <li>
                    En el segundo, las vistas solo necesitan contener html de la página a renderizar, esta luego se incorpora al layout mediante su propiedad {{content}}.
                    Para acceder al mismo, podemos ingresar en la siguiente ruta: <a href="<?= $this->makeUrl('/layout')?>">layout de ejemplo</a><br>
                    Para personalizar el layout, ir a la carpeta <strong><i>View/layout</i></strong>
                </li>
            </ul>
            <p>
                Con la incorporaci&oacute;n de layouts, podremos incluir el js y css com&uacute;n del sitio en el layout, y el js particular (y css, si fuera necesario)
                en su respectivo template. Para tal fin, se provee el m&eacute;todo:  <code><i>loadScript(name, attributes = '')</i></code>
            </p>
            <p>
                El manejo de datos est&aacute; pensado en el uso de la librer&iacute;a de php PDO, por lo cual los modelos pueden usar sql para acceder
                a los datos de la base. Como la idea fue crear un framework para actualizar apps sencillas, esto era lo m&aacute;s conveniente.
                Se podr&iacute;a agregar una librería ORM (como Doctrine) pero s&iacute; el sistema es muy complicado, usar frameworks más potentes.
            </p>
        </section>
    </section>
    <section class="reveal">
        <p>
            Ah, último, pero no menos importante, todos tus assets (im&aacute;genes, estilos, js, otros) deben ir dentro del directorio <strong>public/assets</strong>
            Esto facilita la inclusión de estos archivos en los templates.
            <br><br>
            <strong>Happy coding! 🚀</strong>
        </p>
    </section>

</main>

<!-- Footer -->
<footer class="reveal">
    Simplex Framework, hecho y ajustado por Ignacio Jauregui.
</footer>

<!-- JavaScript -->
<script>
    const reveals = document.querySelectorAll('.reveal');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target); // Se revela solo una vez
            }
        });
    }, { threshold: 0.2 });

    reveals.forEach(el => observer.observe(el));
</script>
</body>
</html>