<?php declare(strict_types=1);

use Psr\Container\ContainerInterface;
use App\Service\UsuariosService;
use App\Service\RolesService;
use App\Service\PermisosService;
use App\Service\OperacionesService;
use App\Service\ModulosService;

$container = $app->getContainer();

$container["usuarios_service"] = function (ContainerInterface $container): UsuariosService {
    return UsuariosService($container->get('usuarios_repository'), $container->get('redis_service'));
};

$container["roles_service"] = function (ContainerInterface $container): RolesService {
    return RolesService($container->get('roles_repository'), $container->get('redis_service'));
};

$container["permisos_service"] = function (ContainerInterface $container): PermisosService {
    return PermisosService($container->get('permisos_repository'), $container->get('redis_service'));
};

$container["operaciones_service"] = function (ContainerInterface $container): OperacionesService {
    return OperacionesService($container->get('operaciones_repository'), $container->get('redis_service'));
};

$container["modulos_service"] = function (ContainerInterface $container): ModulosService {
    return ModulosService($container->get('modulos_repository'), $container->get('redis_service'));
};
