# Simplex Framework

Proyecto base en **PHP** con estructura mínima de carpetas (`src`, `config`, `public`, `test` ), pensado para iniciarlo rápido con [Composer](https://getcomposer.org/).

## 🚀 Instalación

Podés crear un nuevo proyecto a partir de este template con:

```bash
composer create-project ignacio/simplex
```

## Idea

La idea fue replicar el tutorial [Create your own Framework](https://symfony.com/doc/8.0/create_framework/index.html) de Symfony. 
Con esta base, se propuso ajustar el framework para actualizar pequeñas aplicaciones que teniamos en php plano y mejorarlas
sin la necesidad de requerir a frameworks gigantescos como laravel o laminas. 

Segun el tutorial, tenemos dos puntos importantes:

* Un framework funcional con poco codigo
* Un Framework funcional pero que termina siendo un wrapper de la clase HttpKernel de Symfony

Se opto por continuar el desarrollo desde el primer punto pero agregando algunas funcionalidades más:

* Agregar libreria para soporte de archivos .env
* Agregar soporte de Inyectores de dependencias [PHP-DI](https://php-di.org/) 
* Cambiar el punto de acceso de la App de /web/front.php  a /public/index.php.
* Como chiche, se incluyo un archivo ".htaccess_example" para reescribir las rutas de la app y cambiar el index.php/url por /url. Esto es opcional.
* El framework consta con test propios para validar que funcione ante eventuales cambios.
* Ademas agregamos algunos scripts dentro de la configuracion de composer.

Dentro de los scripts podemos: 

Probar la app de bienvenida
```bash
composer start
```
Correr los tests del framework
```bash
composer tests
```

Por último, crear paquete de proyecto de composer para poder instalar esta framework como proyecto base.  