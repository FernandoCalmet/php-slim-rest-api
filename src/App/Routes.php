<?php declare(strict_types=1);

$app->get('/', 'App\Controller\Base\BaseController:getHelp');
$app->get('/status', 'App\Controller\Base\BaseController:getStatus');

$app->get("/usuarios", "App\Controller\Usuarios\GetAll");
$app->get("/usuarios/[{id}]", "App\Controller\Usuarios\GetOne");
$app->post("/usuarios", "App\Controller\Usuarios\Create");
$app->put("/usuarios/[{id}]", "App\Controller\Usuarios\Update");
$app->delete("/usuarios/[{id}]", "App\Controller\Usuarios\Delete");

$app->get("/roles", "App\Controller\Roles\GetAll");
$app->get("/roles/[{id}]", "App\Controller\Roles\GetOne");
$app->post("/roles", "App\Controller\Roles\Create");
$app->put("/roles/[{id}]", "App\Controller\Roles\Update");
$app->delete("/roles/[{id}]", "App\Controller\Roles\Delete");

$app->get("/modulos", "App\Controller\Modulos\GetAll");
$app->get("/modulos/[{id}]", "App\Controller\Modulos\GetOne");
$app->post("/modulos", "App\Controller\Modulos\Create");
$app->put("/modulos/[{id}]", "App\Controller\Modulos\Update");
$app->delete("/modulos/[{id}]", "App\Controller\Modulos\Delete");

$app->get("/operaciones", "App\Controller\Operaciones\GetAll");
$app->get("/operaciones/[{id}]", "App\Controller\Operaciones\GetOne");
$app->post("/operaciones", "App\Controller\Operaciones\Create");
$app->put("/operaciones/[{id}]", "App\Controller\Operaciones\Update");
$app->delete("/operaciones/[{id}]", "App\Controller\Operaciones\Delete");

$app->get("/permisos", "App\Controller\Permisos\GetAll");
$app->get("/permisos/[{id}]", "App\Controller\Permisos\GetOne");
$app->post("/permisos", "App\Controller\Permisos\Create");
$app->put("/permisos/[{id}]", "App\Controller\Permisos\Update");
$app->delete("/permisos/[{id}]", "App\Controller\Permisos\Delete");
