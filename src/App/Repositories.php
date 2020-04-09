<?php declare(strict_types=1);

use Psr\Container\ContainerInterface;
use App\Repository\UsuariosRepository;
use App\Repository\RolesRepository;
use App\Repository\PermisosRepository;
use App\Repository\OperacionesRepository;
use App\Repository\ModulosRepository;

$container = $app->getContainer();

$container["usuarios_repository"] = function (ContainerInterface $container): UsuariosRepository {
    return UsuariosRepository($container->get('db'));
};

$container["roles_repository"] = function (ContainerInterface $container): RolesRepository {
    return RolesRepository($container->get('db'));
};

$container["permisos_repository"] = function (ContainerInterface $container): PermisosRepository {
    return PermisosRepository($container->get('db'));
};

$container["operaciones_repository"] = function (ContainerInterface $container): OperacionesRepository {
    return OperacionesRepository($container->get('db'));
};

$container["modulos_repository"] = function (ContainerInterface $container): ModulosRepository {
    return ModulosRepository($container->get('db'));
};
