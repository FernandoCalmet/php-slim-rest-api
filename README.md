# REST API IN SLIM PHP 🐘

[![License](https://img.shields.io/github/license/fernandocalmet/rest-api-slim-php)](https://github.com/FernandoCalmet/rest-api-slim-php/blob/master/LICENSE.md)
[![Build Status](https://travis-ci.com/FernandoCalmet/rest-api-slim-php.svg?branch=master)](https://travis-ci.com/FernandoCalmet/rest-api-slim-php)
[![Build Status](https://scrutinizer-ci.com/g/FernandoCalmet/rest-api-slim-php/badges/build.png?b=master)](https://scrutinizer-ci.com/g/FernandoCalmet/rest-api-slim-php/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/FernandoCalmet/rest-api-slim-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/FernandoCalmet/rest-api-slim-php/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/FernandoCalmet/rest-api-slim-php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/FernandoCalmet/rest-api-slim-php/?branch=master)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=FernandoCalmet_rest-api-slim-php&metric=alert_status)](https://sonarcloud.io/dashboard?id=FernandoCalmet_rest-api-slim-php)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/FernandoCalmet/rest-api-slim-php/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

[![Quality gate](https://sonarcloud.io/api/project_badges/quality_gate?project=FernandoCalmet_rest-api-slim-php)](https://sonarcloud.io/dashboard?id=FernandoCalmet_rest-api-slim-php)

Principales tecnologías utilizadas: `PHP 7, Slim 3, MySQL, Monolog, Redis, dotenv, PHPUnit y JSON Web Tokens.`

Además, se utilizo otras herramientas adicionales como: `Docker & Docker Compose, Travis CI, Swagger, Scrutinizer, Sonar Cloud, PHPStan, PHP Insights, Heroku and CORS.`

![alt text](extras/img/slim-logo.png "Slim PHP micro framework")

Esta simple **API RESTful**, permite que las operaciones **CRUD** administren recursos como: `Usuarios, Tareas y Notas`.

## :gear: INSTALACIÓN RÁPIDA

### Pre requisitos

- Git.
- Composer.
- PHP 7.4+.
- MySQL/MariaDB.
- Redis (Optional).
- o Docker.

### Redis

Comandos básicos

```bash
# Start Service:
redis-cli

# View All cache:
keys *

# Clean cache:
FLUSHALL

# Query (example of a cached data):
get "rest-api-slim-php:test:status"
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
- [monolog/monolog](https://github.com/Seldaek/monolog): Monolog envía sus registros a archivos, sockets, bandejas de entrada, bases de datos y varios servicios web. Consulte la lista completa de controladores a continuación. Los controladores especiales le permiten crear estrategias de registro avanzadas.

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
PHPUnit 9.3.10 by Sebastian Bergmann and contributors.

...............................................................   63 / 63 (100%)

Time: 00:02.279, Memory: 18.00 MB

OK (63 tests, 390 assertions)
```

## :books: DOCUMENTACIÓN

### ENDPOINTS

HTTP Method | URL | Auth | Descripción
--- | --- | --- | ---
GET | `/` | No | Obtiene la versión, estado y las rutas de los endpoints disponibles de la API, si la petición es exitosa, retornará un status **HTTP 200** (OK).
GET | `/status` | No | Obtiene el estado de los servicios disponibles y la cantidad de los registros en la base de datos, si la petición es exitosa, retornará un status **HTTP 200** (OK). En caso no este conectada la base de datos retornará un status **HTTP 500** (Error).
POST | `/login` | No | Obtiene el JSON Web Token del usuario, si la petición es exitosa, retornará un status **HTTP 200** (OK). En caso de no encontrar o que no coincidan las creedenciales del usuario correspondiente, retornará un status **HTTP 400** (Bad Request).
GET | `/api/v1/users` | Si | Obtiene los usuarios, si la petición es exitosa, retornará un status **HTTP 200** (OK). Si no estas autenticado retornará un status **HTTP 403** (Forbidden). En caso de no encontrar ningun usuario retornará un status **HTTP 404** (Not Found).
GET | `/api/v1/users/{id}` | Si | Obtiene un usuario basado en el Id de la cuenta, si la petición es exitosa, retornará un status **HTTP 200** (OK). Si no estas autenticado retornará un status **HTTP 403** (Forbidden). En caso de no encontrar ningun usuario retornará un status **HTTP 404** (Not Found).
POST | `/api/v1/users` | No | Crea un usuario, la petición deberá incluir los datos dentro del cuerpo de la petición. Si el usuario es creado retornará un status **HTTP 201** (Created). En caso de que exista un dato con restricción unica que este duplicado retornará un status **HTTP 403** (Forbidden).
PUT | `/api/v1/users/{id}` | Si | Actualiza el usuario basado en el Id de la cuenta, si el usuario es actualizado retornará un status **HTTP 200** (OK). Si no estas autenticado retornará un status **HTTP 403** (Forbidden). En caso de que exista un dato con restricción unica que este duplicado retornará un status **HTTP 403** (Forbidden). En caso de no encontrar ningun usuario retornará un status **HTTP 404** (Not Found).
DELETE | `/api/v1/users/{id}` | Si | Elimina un usuario basado en el Id de la cuenta, si el usuario es eliminado retornará un status **HTTP 200** (OK). Si no estas autenticado retornará un status **HTTP 403** (Forbidden). En caso de no encontrar ningun usuario retornará un status **HTTP 404** (Not Found).
GET | `/api/v1/users/search/{query}` | Si | Obtiene resultados relacionados a una busqueda por coincidencias de atributos clave de los usuarios, si se encuentran datos retornará un status **HTTP 200** (OK). Si no estas autenticado retornará un status **HTTP 403** (Forbidden). En caso de no encontrar ningun usuario retornará un status **HTTP 404** (Not Found).
GET | `/api/v1/tasks` | Si | Obtiene las tareas, si la petición es exitosa, retornará un status **HTTP 200** (OK). Si no estas autenticado retornará un status **HTTP 403** (Forbidden). En caso de no encontrar ninguna tarea retornará un status **HTTP 404** (Not Found).
GET | `/api/v1/tasks/{id}` | Si | Obtiene una tarea basado en el Id de la tarea y la sesión del usuario activo, si la petición es exitosa, retornará un status **HTTP 200** (OK). Si no estas autenticado retornará un status **HTTP 403** (Forbidden). En caso de no encontrar ninguna tarea retornará un status **HTTP 404** (Not Found).
POST | `/api/v1/tasks` | Si | Crea una tarea basado en la sesión actual del usuario, la petición deberá incluir los datos dentro del cuerpo de la petición. Si la tarea es creada retornará un status **HTTP 201** (Created). Si no estas autenticado retornará un status **HTTP 403** (Forbidden). En caso de que exista un dato con restricción unica que este duplicado retornará un status **HTTP 403** (Forbidden).
PUT | `/api/v1/tasks/{id}` | Si | Actualiza una tarea basado en el Id de la tarea y la sesión del usuario activo, si la tarea es actualizada retornará un status **HTTP 200** (OK). Si no estas autenticado retornará un status **HTTP 403** (Forbidden). En caso de que exista un dato con restricción unica que este duplicado retornará un status **HTTP 403** (Forbidden). En caso de no encontrar ninguna tarea retornará un status **HTTP 404** (Not Found).
DELETE | `/api/v1/tasks/{id}` | Si | Elimina una tarea basado en el Id de la tarea y la sesión del usuario activo, si la tarea es eliminada retornará un status **HTTP 200** (OK). Si no estas autenticado retornará un status **HTTP 403** (Forbidden). En caso de no encontrar ninguna tarea retornará un status **HTTP 404** (Not Found).
GET | `/api/v1/tasks/search/{query}` | Si | Obtiene resultados relacionados a una busqueda por coincidencias de atributos clave de las tareas basado en la sesión del usuario activo, si se encuentran datos retornará un status **HTTP 200** (OK). Si no estas autenticado retornará un status **HTTP 403** (Forbidden). En caso de no encontrar ninguna tarea retornará un status **HTTP 404** (Not Found).
GET | `/api/v1/notes` | No | Obtiene las notas, si la petición es exitosa, retornará un status **HTTP 200** (OK). En caso de no encontrar ninguna nota retornará un status **HTTP 404** (Not Found).
GET | `/api/v1/notes/{id}` | No | Obtiene una nota basado en el Id, si la petición es exitosa, retornará un status **HTTP 200** (OK). En caso de no encontrar ningun usuario retornará un status **HTTP 404** (Not Found).
POST | `/api/v1/notes` | No | Crea una nota, la petición deberá incluir los datos dentro del cuerpo de la petición. Si la nota es creada retornará un status **HTTP 201** (Created). En caso de que exista un dato con restricción unica que este duplicado retornará un status **HTTP 403** (Forbidden).
PUT | `/api/v1/notes/{id}` | No | Actualiza la nota basado en el Id, si la nota es creado retornará un status **HTTP 200** (OK). En caso de que exista un dato con restricción unica que este duplicado retornará un status **HTTP 403** (Forbidden). En caso de no encontrar ninguna nota retornará un status **HTTP 404** (Not Found).
DELETE | `/api/v1/notes/{id}` | No | Elimina una nota basado en el Id, si la nota es eliminada retornará un status **HTTP 200** (OK). En caso de no encontrar ninguna nota retornará un status **HTTP 404** (Not Found).
GET | `/api/v1/notes/search/{query}` | No | Obtiene resultados relacionados a una busqueda por coincidencias de atributos clave de las notas, si se encuentran datos retornará un status **HTTP 200** (OK). En caso de no encontrar ninguna nota retornará un status **HTTP 404** (Not Found).

### AYUDA Y DOCUMENTACIÓN

### IMPORTA CON POSTMAN

Toda la información de la API, preparada para descargar y usar como colección de postman: [Importar Colección](https://www.getpostman.com/collections/b2198065165c871332cc).

[![Run in Postman](https://run.pstmn.io/button.svg)](https://www.getpostman.com/collections/b2198065165c871332cc)

### OPEN API SPEC

Además, puede ver la especificación de OpenAPI, utilizando [Swagger UI](https://rest-api-slim-php-sql.herokuapp.com/docs/index.html).

## :page_facing_up: LICENCIA

Licencia MIT. Puedes verla en el [Archivo de Licencia](LICENSE.md) para más información.

[Autor](https://github.com/maurobonfietti) de la base de este proyecto, y modificado por el [colaborador](https://github.com/fernandocalmet).
  
---

:octocat: [Puedes seguirme en Github.](https://github.com/FernandoCalmet)

[![ko-fi](https://www.ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/T6T41JKMI)
