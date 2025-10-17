# Simplex Framework

![Build](https://github.com/amazing79/psr15-middlewarestack/actions/workflows/phptests.yml/badge.svg)
![Total Downloads](https://img.shields.io/packagist/dt/amazing79/simplex)
[![Latest Stable Version](https://img.shields.io/packagist/v/amazing79/simplex)](https://packagist.org/packages/amazing79/simplex)
![License](https://img.shields.io/packagist/l/amazing79/simplex)


Proyecto base en **PHP** con estructura mínima de carpetas (`app`, `src`, `config`, `public`, `test` ), pensado para iniciarlo rápido con [Composer](https://getcomposer.org/).

## 🚀 Instalación

Podés crear un nuevo proyecto a partir de este template con:

```bash
  composer create-project amazing79/simplex [nombre_proyecto]
```

## Idea

La idea fue replicar el tutorial [Create your own Framework](https://symfony.com/doc/8.0/create_framework/index.html) de Symfony. 
Con esta base, se propuso ajustar el framework para actualizar pequeñas aplicaciones que teniamos en php plano y mejorarlas
sin la necesidad de requerir a frameworks gigantescos como laravel o láminas. 

Segun el tutorial, tenemos dos puntos importantes:

* Un framework funcional con poco codigo
* Un Framework funcional pero que termina siendo un wrapper de la clase HttpKernel de Symfony

Se optó por continuar el desarrollo desde el primer punto pero agregando algunas funcionalidades más:

* Agregar libreria para soporte de archivos .env
* Agregar soporte de Inyectores de dependencias [PHP-DI](https://php-di.org/) 
* Cambiar el punto de acceso de la App de /web/front.php  a /public/index.php.
* Como chiche, se incluyo un archivo ".htaccess_example" para reescribir las rutas de la app y cambiar el index.php/url por /url. Esto es opcional.
* El framework consta con test propios para validar que funcione ante eventuales cambios.
* Además, agregamos algunos scripts dentro de la configuracion de composer.

Dentro de los scripts podemos: 

Probar la app de bienvenida
```bash
  composer start
```
Correr los tests del framework
```bash
  composer tests
```

## Modo de trabajo

Se incluyo un ejemplo de una página index con su controlador, a modo de entender un poco el funcionamiento. En corto:

* Configurar las dependencias según necesitemos (modelos, nuevos eventos, etc.).
* Reemplazar template de IndexController (welcome) y usar uno propio (también podemos editarlo, como prefieras).
* La metodologia es el patron MVC. Seguir este enfoque, y guardar los scripts en sus respectivas carpetas según su proposito.
* No soporta manejo de sesiones de forma nativa. Esto requiere que lo implementemos nosotros. 
* Los tests actualmente están funcionando, pero solo verifican el funcionamiento del framework desde el punto base. Modificaciones 
al framework por parte de uno podria incluir modificar los tests.
* Se modificó parte del codigo del tutorial para trabajar con Inyectores de dependencias y asi ser más flexible la configuracion del framework.
* Se provee un layout de ejemplo para ver como simplificar el codigo de nuestras vistas. Por lo tanto, para renderizar html contaremos con 
 dos estrategias (HtmlRender y HtmlLayoutRender). En el primero podremos incluir en la plantilla todo el html del documento. En el segundo, las vistas 
 solo necesitan contener html de la página a renderizar, esta luego se incorpora al layout mediante su propiedad {{content}}. Para acceder al mismo, podemos ingresar en la siguiente
ruta: [ruta_principal/layout]. Ejemplo: http://localhost/layout. Para personalizar el layout, ir a la carpeta View/layout/ 
* Se agregó api para manejo de sesiones. Para mayor compatibilidad, se creó usando las interfaces nativas de php. Además, se agregó un controller base para extender 
en aquellos controladores que necesiten acceder a la session (este controller base emplea un trait)

Para marcar un punto personal desde donde empezamos a usarlo como framework, largamos la release de la version v2.0.0. Con esta version procedimos 
a actualizar un par de apps. Nuevamente, este framework tiene objetivo facilitarnos la actualización de sistemas viejos hechos con php plano. Para 
desarrollar apps más complejas, usar otros frameworks.

### Agregados importantes

[Clase Handler para el manejo de sesiones en archivos](./src/Simplex/Sessions/README.md)

[Clase SessionManager para acceder facilmente a la sesion en formato orientado a objetos.](./src/Simplex/Sessions/README.md#sessionmanager-y-staticsessionmanager)

[Trait para reutilizar la clase SessioManager en otras clases o controladores.](./src/Simplex/Traits/README.md)

[Clase AbstractSessionController extendible, el cual utiliza el trait anterior. Esto evita tener que incorporar el trait en todos los controladores.](./src/Simplex/Controllers/README.md)
