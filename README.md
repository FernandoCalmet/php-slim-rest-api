# Aplicación API CRUD + PHP + Slim4 + SQL
> Slim4-API-CRUD-SQL

> Autor : Fernando Calmet  
https://github.com/fernandocalmet  
----------

### Pre Requisitos:

- PHP.
- Composer.
- MySQL/MariaDB.


### Con Composer:

Puede crear un nuevo proyecto ejecutando los siguientes comandos:

```bash
$ composer create-project fernandocalmet/slim4-api-crud-sql [my-api-name]
$ cd [my-api-name]
$ cp .env.example .env
$ composer test
$ composer start
```


#### Configure su conexión al servidor SQL:

Por defecto, la API usa la base de datos MySQL.

Puede verificar y editar esta configuración en su archivo `.env`:

```
DB_HOSTNAME='127.0.0.1'
DB_DATABASE='yourMySqlDatabase'
DB_USERNAME='yourMySqlUsername'
DB_PASSWORD='yourMySqlPassword'
```


## DOCKER DISPONIBLE:

Puedes usar este proyecto con Docker, **docker** y **docker-compose**.


### VERSIÓN MÍNIMA DE DOCKER:

* Engine: 18.03+
* Compose: 1.21+


### COMANDOS DOCKER:

```bash
# Create and start containers for the API.
$ docker-compose up -d --build

# Checkout the API.
$ curl http://localhost:8081

# Stop and remove containers.
$ docker-compose down
```


## DEPENDENCIAS:

### LISTA DE REQUERIMIENTOS DEPENDENCIAS:

- [slim/slim](https://github.com/slimphp/Slim): Slim is a PHP micro framework that helps you quickly write simple yet powerful web applications and APIs.
- [slim/psr7](https://github.com/slimphp/Slim-Psr7): PSR-7 implementation for use with Slim 4.
- [pimple/pimple](https://github.com/silexphp/Pimple): A small PHP dependency injection container.
- [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv): Loads environment variables from `.env` to `getenv()`, `$_ENV` and `$_SERVER` automagically.

### LISTA DE DEPENDENCIAS DE DESARROLLO:

- [phpunit/phpunit](https://github.com/sebastianbergmann/phpunit): The PHP Unit Testing framework.
- [symfony/console](https://github.com/symfony/console): The Console component eases the creation of beautiful and testable command line interfaces.
- [maurobonfietti/slim4-api-skeleton-crud-generator](https://github.com/maurobonfietti/slim4-api-skeleton-crud-generator): CRUD Generator for Slim 4 - Api Skeleton.


## DOCUMENTACIÓN:

### ENDPOINTS POR DEFECTO:

- Help: `GET /`

- Status: `GET /status`
