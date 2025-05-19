# <img src="https://w7.pngwing.com/pngs/399/620/png-transparent-laravel-hd-logo.png" alt="Laravel Logo" width="40" height="40"/> Personas y Mascotas - API

## Diego Alexander Jimenez - API- LARAVEL-JWT

## Prueba técnica Soluciones Fourgen realizada del 17/05/2025 al 18/05/2025

Bienvenido. Esta es la prueba técnica para validar mis conocimientos y fortalezas en el mundo del Backend utilizando Laravel, demostrando así mi capacidad de arquitectura de código, patrones de diseño, clean code, REST, y demás para el mundo de Soluciones Fourgen.

### Implementaciones realizadas:

- **Autenticación JWT**: Configuración e integración de JWT para proteger las rutas de la API, garantizando que solo usuarios autenticados puedan acceder a las operaciones CRUD.
- **CRUD de Personas**: Creación del `PeopleController` para manejar las operaciones CRUD de personas, el cual se lleva a cabo mediante Repositories, FormRequest, Resources.
- **CRUD de Mascotas**: Creación del `PetController` para manejar las operaciones CRUD de mascotas, el cual se lleva a cabo mediante Repositories, FormRequest, Resources.
- **Manejo de Autenticación**: Creación del `AuthController` para manejar las operaciones para registro, inicio y cierre de sesión y obtener la información del usuario mediante Repositories, FormRequest, Resources.
- **Relación Persona-Mascotas**: Establecimiento de la relación uno-a-muchos entre los modelos `People` y `Pet`, permitiendo que una persona pueda tener múltiples mascotas.
- **Protección de Rutas**: Implementación de middleware para asegurar que todas las rutas relacionadas con tareas estén protegidas por autenticación JWT.
- **Conexión con API externa**: Implementación de Service para conexión con `TheCatAPI` para obtener información como la raza y una imagen y completar el registro de una nueva mascota.
- **Documentación con Swagger**: Implementación de la libreria Swagger para documentar los endpoints del API para realizar pruebas y verificacion de funcionamiento.
- **Pruebas de integración**: Implementación de pruebas para testear el funcionamiento del API.


# Contenido
* Instrucciones para el correcto funcionamiento
* Herramientas de desarrollo utilizadas
* Documentación del API en Swagger
* Colección de Postman


## Instalación:
1. **Crear una base de datos MySQL**: Crea una base de `prueba_soluciones_fourgen` datos en tu servidor MySQL donde se almacenarán los datos del proyecto.

2. **Clonar o descargar el proyecto**:
    - Clona el repositorio utilizando Git:
      ```bash
      git clone <URL-del-repositorio>
      ```
    - O descarga el proyecto como un archivo ZIP y extráelo en el directorio de tu servidor web.

3. **Acceder mediante terminal a la carpeta del proyecto**:
    - Navega hasta la carpeta raíz del proyecto:
      ```bash
      cd <nombre-del-proyecto>
      ```

4. **Instalar dependencias**:
    - Ejecuta el siguiente comando para instalar las dependencias del proyecto:
      ```bash
      composer install
      ```

5. **Configurar el archivo de entorno**:
    - Copia el archivo de entorno de ejemplo y renómbralo a `.env`:
      ```bash
      cp .env.example .env
      ```

6. **Generar la clave de la aplicación**:
    - Genera una clave de la aplicación ejecutando:
      ```bash
      php artisan key:generate
      ```

7. **Configurar la base de datos**:
    - Abre el archivo `.env` en un editor de texto y configura los detalles de tu base de datos:
      ```plaintext
      DB_CONNECTION=mysql
      DB_HOST=127.0.0.1
      DB_PORT=5432
      DB_DATABASE=nombre_de_tu_base_de_datos
      DB_USERNAME=tu_usuario
      DB_PASSWORD=tu_contraseña
      ```

8. **Generar el JWT Secret**:
    - Genera el secreto JWT necesario para la autenticación:
      ```bash
      php artisan jwt:secret
      ```
      
9. **Correr Migraciones del proyecto **:
    - Genera las tablas requeridas para el proyecto:
      ```bash
      php artisan migrate
      ```
10. **Correr seeders del proyecto **:
    - Genera las seeders requeridos para usuarios de prueba:
      ```bash
      php artisan db:seed
      ```

11. **Levantar el servidor**:
    - Inicia el servidor de desarrollo de Laravel con:
      ```bash
      php artisan serve

## HERRAMIENTAS DE DESARROLLO UTILIZADAS
* Laravel Framework v9
* PHP 8.2.4 
* Visual Studio Code
* Postman
* Swagger
* Laragon
* Navicat
* Git
* GitHub

## Diagrama de la Base de Datos

A continuación se muestra el diagrama de la base de datos que ilustra la estructura y relaciones entre las tablas de la aplicación:

![Diagrama de la Base de Datos](https://github.com/goslip05/Prueba-Andes-Backend/blob/main/public/img/Diagrama_DB)


## Documentación del API en Swagger
Si deseas probar la API en Swagger, sigue estos pasos:
1. Revisa la documentación que se encuentra en el repositorio (si está disponible) o crea manualmente las solicitudes según las rutas de la API.
2. Asegúrate de que el servidor de desarrollo de Laravel esté en ejecución.
3. Utiliza la URL base `http://prueba-soluciones-fourgen.test//api` para todas las solicitudes API, se uso Laragon para la construcción de la API.
4. Realiza una solicitud POST a `/login` con las credenciales de un usuario registrado para obtener el token JWT.
5. Incluye el token en las solicitudes posteriores usando el encabezado `Authorization: Bearer <tu_token_jwt>` para acceder a las rutas protegidas.

## Documentación de Swagger

Puedes utilizar la documentación de Swagger para validar la documentación de la API del proyecto, así como para interactuar con los endpoints utilizados.

<a href="http://prueba-soluciones-fourgen.test/api/documentation" target="_blank">Ver Documentación API</a>

## Colección de Postman

Puedes utilizar la siguiente colección de Postman para validar la documentación de la API del proyecto, así como para interactuar con los endpoints utilizados.

<a href="https://documenter.getpostman.com/view/18148117/2sB2qXk3AE" target="_blank">Ver Colección Postman</a>