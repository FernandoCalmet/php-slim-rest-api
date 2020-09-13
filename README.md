# REST API IN SLIM PHP 🐘

[![License](https://img.shields.io/github/license/fernandocalmet/rest-api-slim-php)](https://github.com/FernandoCalmet/rest-api-slim-php/blob/master/LICENSE.md)
[![Build Status](https://travis-ci.com/FernandoCalmet/rest-api-slim-php.svg?branch=master)](https://travis-ci.com/FernandoCalmet/rest-api-slim-php)
[![Build Status](https://scrutinizer-ci.com/g/FernandoCalmet/rest-api-slim-php/badges/build.png?b=master)](https://scrutinizer-ci.com/g/FernandoCalmet/rest-api-slim-php/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/FernandoCalmet/rest-api-slim-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/FernandoCalmet/rest-api-slim-php/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/FernandoCalmet/rest-api-slim-php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/FernandoCalmet/rest-api-slim-php/?branch=master)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=FernandoCalmet_rest-api-slim-php&metric=alert_status)](https://sonarcloud.io/dashboard?id=FernandoCalmet_rest-api-slim-php)

[![Quality gate](https://sonarcloud.io/api/project_badges/quality_gate?project=FernandoCalmet_rest-api-slim-php)](https://sonarcloud.io/dashboard?id=FernandoCalmet_rest-api-slim-php)

Principales tecnologías utilizadas: `PHP 7, Slim 3, MySQL, Redis, dotenv, PHPUnit y JSON Web Tokens.`

Además, se utilizo otras herramientas adicionales como: `Docker & Docker Compose, Travis CI, Swagger, Scrutinizer, Sonar Cloud, PHPStan, PHP Insights, Heroku and CORS.`

![alt text](extras/img/slim-logo.png "Slim PHP micro framework")

Esta simple **API RESTful**, permite que las operaciones **CRUD** administren recursos como: `Usuarios, Tareas y Notas`.

## :gear: INSTALACIÓN RÁPIDA

### Pre requisitos

- Git.
- Composer.
- PHP 7.3+.
- MySQL/MariaDB.
- Redis (Optional).
- o Docker.

### REDIS

Comando básico

```bash
Start Service: redis-cli
View All cache: keys *
Clean cache: FLUSHALL
Query (example of a cached data): get "rest-api-slim-php:test:status"
```

### Con Composer

Puede crear un nuevo proyecto ejecutando los siguientes comandos:

```bash
composer create-project fernandocalmet/rest-api-slim-php [my-api-name]
cd [my-api-name]
composer restart-db
composer test
composer start
```

### Con Git

En su terminal, ejecute estos comandos:

```bash
git clone https://github.com/fernandocalmet/rest-api-slim-php.git && cd rest-api-slim-php
cp .env.example .env
composer install
composer restart-db
composer test
composer start
```

### Con Docker

Puedes usar este proyecto usando **docker** y **docker-compose**.

**Versión Minimal Docker:**

- Engine: 18.03+
- Compose: 1.21+

**Comandos:**

```bash
# Start the API (this is my alias for: docker-compose up -d --build).
$ make up

# To create the database and import test data from scratch.
$ make db

# Checkout the API.
$ curl http://localhost:8080

# Stop and remove containers (it's like: docker-compose down).
$ make down
```

### Migración de Base de Datos

**Comandos:**

```bash
composer restart-db
```

## :inbox_tray: DEPENDENCIAS

### LISTA DE REQUISITOS DEPENDENCIAS

- [slim/slim](https://github.com/slimphp/Slim): Slim es un micro framework PHP que le ayuda a escribir rápidamente aplicaciones web y APIs simples pero potentes.
- [respect/validation](https://github.com/Respect/Validation): El motor de validación más impresionante jamás creado para PHP.
- [palanik/corsslim](https://github.com/palanik/CorsSlim): Middleware de intercambio de recursos de origen cruzado (CORS) para PHP Slim.
- [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv): Carga variables de entorno desde `.env` a `getenv()`,`$ _ENV` y `$ _SERVER` automágicamente.
- [predis/predis](https://github.com/nrk/predis/): Cliente Redis flexible y con todas las funciones para PHP y HHVM.
- [firebase/php-jwt](https://github.com/firebase/php-jwt): Una biblioteca simple para codificar y decodificar JSON Web Tokens (JWT) en PHP.

### LISTA DE DEPENDENCIAS DE DESARROLLO

- [phpunit/phpunit](https://github.com/sebastianbergmann/phpunit): El marco de pruebas unitarias de PHP.
- [phpstan/phpstan](https://github.com/phpstan/phpstan): PHPStan - Herramienta de análisis estático de PHP.
- [pestphp/pest](https://github.com/pestphp/pest): Pest es un elegante marco de pruebas PHP con un enfoque en la simplicidad.
- [nunomaduro/phpinsights](https://github.com/nunomaduro/phpinsights): Comprobaciones instantáneas de calidad de PHP desde su consola.
- [rector/rector](https://github.com/rectorphp/rector): Actualizaciones instantáneas y refactorización instantánea de cualquier código PHP 5.3+.
- [vimeo/psalm](https://github.com/vimeo/psalm): Una herramienta de análisis estático para encontrar errores en aplicaciones PHP.

## :traffic_light: TESTING

Ejecute todas las pruebas de PHPUnit con `composer test`.

```bash
$ composer test
> phpunit
PHPUnit 9.4 by Sebastian Bergmann and contributors.

...............................................................   62 / 62 (100%)

Time: 00:04.683, Memory: 16.00 MB

OK (62 tests, 386 assertions)
```

## :books: DOCUMENTACIÓN

### ENDPOINTS

#### INFO

- Help: `GET /`
- Status: `GET /status`

#### USERS

- Login User: `POST /login`
- Get All Users: `GET /api/v1/users`
- Get One User: `GET /api/v1/users/{id}`
- Create User: `POST /api/v1/users`
- Update User: `PUT /api/v1/users/{id}`
- Delete User: `DELETE /api/v1/users/{id}`
- Search Users: `GET /api/v1/users/search/{query}`

#### TASKS

- Get All Tasks: `GET /api/v1/tasks`
- Get One Task: `GET /api/v1/tasks/{id}`
- Create Task: `POST /api/v1/tasks`
- Update Task: `PUT /api/v1/tasks/{id}`
- Delete Task: `DELETE /api/v1/tasks/{id}`
- Search Tasks: `GET /api/v1/tasks/search/{query}`

#### NOTES

- Get All Notes: `GET /api/v1/notes`
- Get One Note: `GET /api/v1/notes/{id}`
- Create Note: `POST /api/v1/notes`
- Update Note: `PUT /api/v1/notes/{id}`
- Delete Note: `DELETE /api/v1/notes/{id}`
- Search Notes: `GET /api/v1/notes/search/{query}`

### AYUDA Y DOCUMENTACIÓN

### IMPORTA CON POSTMAN

Toda la información de la API, preparada para descargar y usar como colección de postman: [Importar Colección](https://www.getpostman.com/collections/b2198065165c871332cc).

[![Run in Postman](https://run.pstmn.io/button.svg)](https://www.getpostman.com/collections/b2198065165c871332cc)

### OPEN API SPEC

Además, puede ver la especificación de OpenAPI, utilizando [Swagger UI](https://rest-api-slim-php-sql.herokuapp.com/docs/index.html).

## :page_facing_up: LICENCIA

Licencia MIT. Puedes verla en el [Archivo de Licencia](LICENSE.md) para más información.
  
---

:octocat: [Puedes seguirme en Github.](https://github.com/FernandoCalmet)

[![ko-fi](https://www.ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/T6T41JKMI)
