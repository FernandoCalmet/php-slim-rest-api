# REST API IN SLIM PHP 🐘

[![License](https://img.shields.io/github/license/fernandocalmet/rest-api-slim-php)](https://github.com/FernandoCalmet/rest-api-slim-php/blob/master/LICENSE.md)
[![Build Status](https://travis-ci.com/FernandoCalmet/rest-api-slim-php.svg?branch=master)](https://travis-ci.com/FernandoCalmet/rest-api-slim-php)
[![Build Status](https://scrutinizer-ci.com/g/FernandoCalmet/rest-api-slim-php/badges/build.png?b=master)](https://scrutinizer-ci.com/g/FernandoCalmet/rest-api-slim-php/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/FernandoCalmet/rest-api-slim-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/FernandoCalmet/rest-api-slim-php/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/FernandoCalmet/rest-api-slim-php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/FernandoCalmet/rest-api-slim-php/?branch=master)

Main technologies used: `PHP 7, Slim 3, MySQL, Redis, dotenv, PHPUnit and JSON Web Tokens.`

Also, I use other aditional tools like: `Docker & Docker Compose, Travis CI, Swagger, Code Climate, Scrutinizer, Sonar Cloud, PHPStan, PHP Insights, Heroku and CORS.`

![alt text](extras/img/slim-logo.png "Slim PHP micro framework")

This simple RESTful API, allows CRUD operations to manage resources like: Users, Tasks and Notes.

## :gear: QUICK INSTALL

### Pre Requirements

- Git.
- Composer.
- PHP 7.3+.
- MySQL/MariaDB.
- Redis (Optional).
- or Docker.

### REDIS

Basic Commands

```bash
Start Service: redis-cli
View All cache: keys *
Clean cache: FLUSHALL
Query (example of a cached data): get "rest-api-slim-php:test:status"
```

### With Composer

You can create a new project by running the following commands:

```bash
composer create-project fernandocalmet/rest-api-slim-php [my-api-name]
cd [my-api-name]
composer restart-db
composer test
composer start
```

### With Git

In your terminal run these commands:

```bash
git clone https://github.com/fernandocalmet/rest-api-slim-php.git && cd rest-api-slim-php
cp .env.example .env
composer install
composer restart-db
composer test
composer start
```

### With Docker

You can use this project using **docker** and **docker-compose**.

**Minimal Docker Version:**

- Engine: 18.03+
- Compose: 1.21+

**Commands:**

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

### Database migration

**Commands:**

```bash
composer restart-db
```

## :inbox_tray: DEPENDENCIES

### LIST OF REQUIREMENTS DEPENDENCIES

- [slim/slim](https://github.com/slimphp/Slim): Slim is a PHP micro framework that helps you quickly write simple yet powerful web applications and APIs.
- [respect/validation](https://github.com/Respect/Validation): The most awesome validation engine ever created for PHP.
- [palanik/corsslim](https://github.com/palanik/CorsSlim): Cross-origin resource sharing (CORS) middleware for PHP Slim.
- [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv): Loads environment variables from `.env` to `getenv()`, `$_ENV` and `$_SERVER` automagically.
- [predis/predis](https://github.com/nrk/predis/): Flexible and feature-complete Redis client for PHP and HHVM.
- [firebase/php-jwt](https://github.com/firebase/php-jwt): A simple library to encode and decode JSON Web Tokens (JWT) in PHP.

### LIST OF DEVELOPMENT DEPENDENCIES

- [phpunit/phpunit](https://github.com/sebastianbergmann/phpunit): The PHP Unit Testing framework.
- [phpstan/phpstan](https://github.com/phpstan/phpstan): PHPStan - PHP Static Analysis Tool.
- [pestphp/pest](https://github.com/pestphp/pest): Pest is an elegant PHP Testing Framework with a focus on simplicity.
- [nunomaduro/phpinsights](https://github.com/nunomaduro/phpinsights): Instant PHP quality checks from your console.
- [rector/rector](https://github.com/rectorphp/rector): Instant Upgrades and Instant Refactoring of any PHP 5.3+ code.
- [vimeo/psalm](https://github.com/vimeo/psalm): A static analysis tool for finding errors in PHP applications.

## :traffic_light: TESTING

Run all PHPUnit tests with `composer test`.

```bash
$ composer test
> phpunit
PHPUnit 9.4 by Sebastian Bergmann and contributors.

...............................................................   62 / 62 (100%)

Time: 00:04.683, Memory: 16.00 MB

OK (62 tests, 386 assertions)
```

## :books: DOCUMENTATION

### ENDPOINTS

#### INFO

- Help: `GET /`
- Status: `GET /status`

#### USERS

- Login User: `POST /login`
- Create User: `POST /api/v1/users`
- Update User: `PUT /api/v1/users/{id}`
- Delete User: `DELETE /api/v1/users/{id}`

#### TASKS

- Get All Tasks: `GET /api/v1/tasks`
- Get One Task: `GET /api/v1/tasks/{id}`
- Create Task: `POST /api/v1/tasks`
- Update Task: `PUT /api/v1/tasks/{id}`
- Delete Task: `DELETE /api/v1/tasks/{id}`

#### NOTES

- Get All Notes: `GET /api/v1/notes`
- Get One Note: `GET /api/v1/notes/{id}`
- Create Note: `POST /api/v1/notes`
- Update Note: `PUT /api/v1/notes/{id}`
- Delete Note: `DELETE /api/v1/notes/{id}`

Also, you can see the API documentation with the [full list of endpoints](extras/docs/endpoints.md).

### HELP AND DOCS

### IMPORT WITH POSTMAN

All the information of the API, prepared to download and use as postman collection: [Import Collection](https://www.getpostman.com/collections/b2198065165c871332cc).

[![Run in Postman](https://run.pstmn.io/button.svg)](https://www.getpostman.com/collections/b2198065165c871332cc)

### OPEN API SPEC

Also, you can view the OpenAPI Specification, using [Swagger UI](https://rest-api-slim-php-sql.herokuapp.com/docs/index.html).

## :page_facing_up: LICENSE

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
  
---

:octocat: [Check more about my repositories](https://github.com/FernandoCalmet)

[![ko-fi](https://www.ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/T6T41JKMI)
