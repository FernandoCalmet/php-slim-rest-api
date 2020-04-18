# Slim4 Restful CRUD Application
> author: github.com/fernandocalmet  
  

## QUICK INSTALL:

### Pre Requirements:

- Git.
- Composer.
- PHP.
- MySQL/MariaDB.
- Redis (Optional).

### REDIS:

Basic Commands

```bash
Start Service: redis-cli
View All cache: keys *
Clean cache: FLUSHALL
Query (example of a cached data): get "slim4-api-crud-sql:test:status"
```

### With Composer:

You can create a new project by running the following commands:

```bash
$ composer create-project fernandocalmet/slim4-api-crud-sql [my-api-name]
$ cd [my-api-name]
$ cp .env.example .env
$ composer database
$ composer start
```


### With Git:

In your terminal run these commands:

```bash
$ git clone https://github.com/fernandocalmet/slim4-api-crud-sql.git && cd slim4-api-crud-sql
$ cp .env.example .env
$ composer install
$ composer database
$ composer start
```

### With Docker:

You can use this project using ** docker ** and ** docker-compose **.


### Minimal Docker Version:

* Engine: 18.03+
* Compose: 1.21+


**Commands:**

```bash
# Start the API (this is my alias for: docker-compose up -d --build).
$ make up

# To create the database and import test data from scratch.
$ make db

# Checkout the API.
$ curl http://localhost:8081

# Stop and remove containers (it's like: docker-compose down).
$ make down
```

### Database migration:

**Commands:**

```bash
$ composer migration
```

## DEPENDENCIES:

### LIST OF REQUIREMENTS DEPENDENCIES:

- [slim/slim](https://github.com/slimphp/Slim): Slim is a PHP micro framework that helps you quickly write simple yet powerful web applications and APIs.
- [respect/validation](https://github.com/Respect/Validation): The most awesome validation engine ever created for PHP.
- [palanik/corsslim](https://github.com/palanik/CorsSlim): Cross-origin resource sharing (CORS) middleware for PHP Slim.
- [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv): Loads environment variables from `.env` to `getenv()`, `$_ENV` and `$_SERVER` automagically.
- [predis/predis](https://github.com/phpredis/phpredis): A PHP extension for Redis.
- [firebase/php-jwt](https://github.com/firebase/php-jwt): A simple library to encode and decode JSON Web Tokens (JWT) in PHP.
- [pimple/pimple](https://github.com/silexphp/Pimple): A small PHP dependency injection container.
- [slim/psr7](https://github.com/slimphp/Slim-Psr7): PSR-7 implementation for use with Slim 4.

### LIST OF DEVELOPMENT DEPENDENCIES:

- [phpunit/phpunit](https://github.com/sebastianbergmann/phpunit): The PHP Unit Testing framework.
- [phpstan/phpstan](https://github.com/phpstan/phpstan): PHPStan - PHP Static Analysis Tool.
- [symfony/console](https://github.com/symfony/console): The Console component eases the creation of beautiful and testable command line interfaces.


## TESTS:

Run all PHPUnit tests with `composer test`.

## DOCUMENTATION:

### ENDPOINTS:

#### INFO:
- Help: `GET /`
- Status: `GET /status`
- Login: `POST /login`
- SignUp: `POST /signup`


#### USERS:
- Get All: `GET /api/v1/users`
- Get One: `GET /api/v1/users/{id}`
- Create: `POST /api/v1/users`
- Update: `PUT /api/v1/users/{id}`
- Delete: `DELETE /api/v1/users/{id}`
- Query: `DELETE /api/v1/users/search/[{query}]`

#### ROLES:
- Get All: `GET /api/v1/roles`
- Get One: `GET /api/v1/roles/{id}`
- Create: `POST /api/v1/roles`
- Update: `PUT /api/v1/roles/{id}`
- Delete: `DELETE /api/v1/roles/{id}`
- Query: `DELETE /api/v1/roles/search/[{query}]`

#### PERMISSIONS:
- Get All: `GET /api/v1/permissions`
- Get One: `GET /api/v1/permissions/{id}`
- Create: `POST /api/v1/permissions`
- Update: `PUT /api/v1/permissions/{id}`
- Delete: `DELETE /api/v1/permissions/{id}`
- Query: `DELETE /api/v1/permissions/search/[{query}]`

#### OPERATIONS:
- Get All: `GET /api/v1/operations`
- Get One: `GET /api/v1/operations/{id}`
- Create: `POST /api/v1/operations`
- Update: `PUT /api/v1/operations/{id}`
- Delete: `DELETE /api/v1/operations/{id}`
- Query: `DELETE /api/v1/operations/search/[{query}]`

#### MODULES:
- Get All: `GET /api/v1/modules`
- Get One: `GET /api/v1/modules/{id}`
- Create: `POST /api/v1/modules`
- Update: `PUT /api/v1/modules/{id}`
- Delete: `DELETE /api/v1/modules/{id}`
- Query: `DELETE /api/v1/modules/search/[{query}]`

#### PROFILES:
- Get All: `GET /api/v1/profiles`
- Get One: `GET /api/v1/profiles/{id}`
- Create: `POST /api/v1/profiles`
- Update: `PUT /api/v1/profiles/{id}`
- Delete: `DELETE /api/v1/profiles/{id}`
- Query: `DELETE /api/v1/profiles/search/[{query}]`

  
## SUPPORT ME WITH A COFFEE:-)

<a href='https://ko-fi.com/fernandocalmet' target='_blank'>
  <img height='36' style='border:0px;height:36px;' src='https://az743702.vo.msecnd.net/cdn/kofi3.png?v=2' border='0' alt='Buy Me a Coffee at ko-fi.com' />
</a>