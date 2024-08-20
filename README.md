# Aplicación Shop Test

Esta es una aplicación profesional de Laravel que utiliza las siguientes tecnologías:

- Framework Laravel
- Vite para gestionar activos y JavaScript

## Despliegue

Para desplegar la aplicación, sigue estos pasos:

1. Clona el repositorio: `git clone https://github.com/Cristhian9507/shoptest`
2. Instala las dependencias: `composer install && npm install`
3. Configura las variables de entorno en el archivo `.env`.
4. Ejecuta las migraciones de la base de datos y siembra la base de datos: `php artisan migrate --seed`
5. Inicia el servidor de desarrollo: `php artisan serve`

## Credenciales de inicio de sesión

Para iniciar sesión en la aplicación, utiliza las siguientes credenciales:

- Correo electrónico: test@example.com
- Contraseña: password

## Módulos

La aplicación consta de los siguientes módulos principales:

1. Cliente: Gestiona la información del cliente.
2. Producto: Maneja la gestión de productos.
3. Orden: Se encarga del procesamiento de pedidos.

Además, hay un módulo de API que obtiene información de una API externa.

## Integración de API

El módulo de API es responsable de obtener y mostrar información de una API externa. Proporciona una integración perfecta con la aplicación.

## Licencia

Esta aplicación Laravel es un software de código abierto con licencia MIT.

