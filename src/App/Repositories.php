<?php

declare(strict_types=1);

use App\Repository\UserRepository;
use App\Repository\ProfileRepository;
use App\Repository\ModuleRepository;
use App\Repository\RoleRepository;
use App\Repository\PermissionRepository;
use App\Repository\OperationRepository;
use Psr\Container\ContainerInterface;

$container = $app->getContainer();

$container['user_repository'] = function (ContainerInterface $container): UserRepository {
    return new UserRepository($container->get('db'));
};

$container['profile_repository'] = function (ContainerInterface $container): ProfileRepository {
    return new ProfileRepository($container->get('db'));
};

$container['module_repository'] = function (ContainerInterface $container): ModuleRepository {
    return new ModuleRepository($container->get('db'));
};

$container['role_repository'] = function (ContainerInterface $container): RoleRepository {
    return new RoleRepository($container->get('db'));
};

$container['permission_repository'] = function (ContainerInterface $container): PermissionRepository {
    return new PermissionRepository($container->get('db'));
};

$container['operation_repository'] = function (ContainerInterface $container): OperationRepository {
    return new OperationRepository($container->get('db'));
};
