<?php declare(strict_types=1);

$app->get('/', 'App\Controller\DefaultController:getHelp');
$app->get('/status', 'App\Controller\DefaultController:getStatus');

$app->post('/login', 'App\Controller\User\Login')->add(new App\Middleware\AuthMiddleware($app));

$app->group('/api/v1', function () use ($app) {
  
    $app->group('/usuarios', function () use ($app) {
        $app->get("", "App\Controller\Usuarios\GetAll");
        $app->get("/[{id}]", "App\Controller\Usuarios\GetOne");
        $app->get('/search/[{query}]', 'App\Controller\Usuarios\Search');
        $app->post("", "App\Controller\Usuarios\Create");
        $app->put("/[{id}]", "App\Controller\Usuarios\Update");
        $app->delete("/[{id}]", "App\Controller\Usuarios\Delete");
    });

    $app->group('/roles', function () use ($app) {
        $app->get("", "App\Controller\Roles\GetAll");
        $app->get("/[{id}]", "App\Controller\Roles\GetOne");
        $app->get('/search/[{query}]', 'App\Controller\Roles\Search');
        $app->post("", "App\Controller\Roles\Create");
        $app->put("/[{id}]", "App\Controller\Roles\Update");
        $app->delete("/[{id}]", "App\Controller\Roles\Delete");
    });    
   
    $app->group('/permisos', function () use ($app) {
        $app->get("", "App\Controller\Permisos\GetAll");
        $app->get("/[{id}]", "App\Controller\Permisos\GetOne");
        $app->get('/search/[{query}]', 'App\Controller\Permisos\Search');
        $app->post("", "App\Controller\Permisos\Create");
        $app->put("/[{id}]", "App\Controller\Permisos\Update");
        $app->delete("/[{id}]", "App\Controller\Permisos\Delete");
    });

    $app->group('/operaciones', function () use ($app) {
        $app->get("", "App\Controller\Operaciones\GetAll");
        $app->get("/[{id}]", "App\Controller\Operaciones\GetOne");
        $app->get('/search/[{query}]', 'App\Controller\Operaciones\Search');
        $app->post("", "App\Controller\Operaciones\Create");
        $app->put("/[{id}]", "App\Controller\Operaciones\Update");
        $app->delete("/[{id}]", "App\Controller\Operaciones\Delete");
    });

    $app->group('/modulos', function () use ($app) {
        $app->get("", "App\Controller\Modulos\GetAll");
        $app->get("/[{id}]", "App\Controller\Modulos\GetOne");
        $app->get('/search/[{query}]', 'App\Controller\Modulos\Search');
        $app->post("", "App\Controller\Modulos\Create");
        $app->put("/[{id}]", "App\Controller\Modulos\Update");
        $app->delete("/[{id}]", "App\Controller\Modulos\Delete");
    });

});
