<?php declare(strict_types=1);

use Psr\Container\ContainerInterface;

$container = $app->getContainer();

$container["usuarios_repository"] = function ($container): App\Repository\UsuariosRepository {
    return new App\Repository\UsuariosRepository($container["db"]);
};

$container["roles_repository"] = function ($container): App\Repository\RolesRepository {
    return new App\Repository\RolesRepository($container["db"]);
};

$container["permisos_repository"] = function ($container): App\Repository\PermisosRepository {
    return new App\Repository\PermisosRepository($container["db"]);
};

$container["operaciones_repository"] = function ($container): App\Repository\OperacionesRepository {
    return new App\Repository\OperacionesRepository($container["db"]);
};

$container["modulos_repository"] = function ($container): App\Repository\ModulosRepository {
    return new App\Repository\ModulosRepository($container["db"]);
};
