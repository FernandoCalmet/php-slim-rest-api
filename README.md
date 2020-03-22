# Aplicación API CRUD + PHP + Slim4 + SQL
> Autor : Fernando Calmet  
https://github.com/fernandocalmet  
----------

<p>Esta aplicación de muestra está destinada a proporcionar un ejemplo práctico de una aplicación modular desarrollada por mi propio criterio.

<p>Tenga en cuenta que si bien este programa de ejemplo funciona, las características mencionadas anteriormente no están destinadas a ser tomadas y utilizadas en aplicaciones comerciales de producción. En otras palabras, este no es un proyecto semilla para ser tomado  e implementado en su entorno de producción.</p>  

<p>Por ejemplo, ciertos problemas no se abordan en absoluto en esta  muestra (por ejemplo, seguridad, privacidad, entre otros). En esta aplicación de muestra, se enfoca por lograr un equilibrio entre claridad, facilidad de mantenimiento y rendimiento. Sin embargo, la claridad es, en última instancia, la cualidad más importante en una aplicación de muestra.</p>

<p>Por lo tanto, hay ciertos casos en los que podríamos renunciar a una implementación más complicada (por ejemplo, el almacenamiento en caché de un valor de uso frecuente, un manejo robusto de errores, una estructura de modelo de dominio más genérico) a favor de un código que sea más fácil de leer. En ese sentido, agradezco cualquier comentario que haga que esta aplicación de muestra sean más fácil de aprender.</p>

### Pre Requisitos:
- PHP.
- Composer.
- MySQL/MariaDB.


### Composer:
Puede crear un nuevo proyecto ejecutando los siguientes comandos:

```bash
$ composer create-project fernandocalmet/slim4-api-crud-sql [my-api-name]
$ cd [my-api-name]
$ cp .env.example .env
$ composer test
$ composer start
```


#### Configuración de conexión al servidor SQL:
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

- [slim/slim](https://github.com/slimphp/Slim): Slim es un micro framework PHP que lo ayuda a escribir rápidamente aplicaciones web y API simples pero potentes.
- [slim/psr7](https://github.com/slimphp/Slim-Psr7): Implementación de PSR-7 para usar con Slim 4.
- [pimple/pimple](https://github.com/silexphp/Pimple): Un pequeño contenedor de inyección de dependencia de PHP.
- [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv): Carga variables de entorno de `.env` a` getenv () `,` $ _ENV` y `$ _SERVER` automáticamente.

### LISTA DE DEPENDENCIAS DE DESARROLLO:

- [phpunit/phpunit](https://github.com/sebastianbergmann/phpunit): El marco de pruebas de unidad PHP.
- [symfony/console](https://github.com/symfony/console): El componente Consola facilita la creación de interfaces de línea de comandos hermosas y comprobables.

## DOCUMENTACIÓN:

### ENDPOINTS POR DEFECTO:

- Help: `GET /`
- Status: `GET /status`

#### USUARIOS:

- Login: `POST /login`

- Get All: `GET /api/v1/usuarios`

- Get One: `GET /api/v1/usuarios/{id}`

- Create: `POST /api/v1/usuarios`

- Update: `PUT /api/v1/usuarios/{id}`

- Delete: `DELETE /api/v1/usuarios/{id}`

- Query: `DELETE /api/v1/usuarios/search/[{query}]`

#### ROLES:

- Get All: `GET /api/v1/roles`

- Get One: `GET /api/v1/roles/{id}`

- Create: `POST /api/v1/roles`

- Update: `PUT /api/v1/roles/{id}`

- Delete: `DELETE /api/v1/roles/{id}`

- Query: `DELETE /api/v1/roles/search/[{query}]`

#### PERMISOS:

- Get All: `GET /api/v1/permisos`

- Get One: `GET /api/v1/permisos/{id}`

- Create: `POST /api/v1/permisos`

- Update: `PUT /api/v1/permisos/{id}`

- Delete: `DELETE /api/v1/permisos/{id}`

- Query: `DELETE /api/v1/permisos/search/[{query}]`

#### OPERACIONES:

- Get All: `GET /api/v1/operaciones`

- Get One: `GET /api/v1/operaciones/{id}`

- Create: `POST /api/v1/operaciones`

- Update: `PUT /api/v1/operaciones/{id}`

- Delete: `DELETE /api/v1/operaciones/{id}`

- Query: `DELETE /api/v1/operaciones/search/[{query}]`

#### MODULOS:

- Get All: `GET /api/v1/modulos`

- Get One: `GET /api/v1/modulos/{id}`

- Create: `POST /api/v1/modulos`

- Update: `PUT /api/v1/modulos/{id}`

- Delete: `DELETE /api/v1/modulos/{id}`

- Query: `DELETE /api/v1/modulos/search/[{query}]`