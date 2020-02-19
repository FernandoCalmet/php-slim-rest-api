<?php declare(strict_types=1);

$container["usuarios_service"] = function ($container): App\Service\UsuariosService {
    return new App\Service\UsuariosService($container["usuarios_repository"]);
};

$container["roles_service"] = function ($container): App\Service\RolesService {
    return new App\Service\RolesService($container["roles_repository"]);
};

$container["modulos_service"] = function ($container): App\Service\ModulosService {
    return new App\Service\ModulosService($container["modulos_repository"]);
};

$container["operaciones_service"] = function ($container): App\Service\OperacionesService {
    return new App\Service\OperacionesService($container["operaciones_repository"]);
};

$container["permisos_service"] = function ($container): App\Service\PermisosService {
    return new App\Service\PermisosService($container["permisos_repository"]);
};
