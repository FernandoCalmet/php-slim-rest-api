<?php

declare(strict_types=1);

use App\Service\User\UserService;
use App\Service\Profile\ProfileService;
use App\Service\Module\ModuleService;
use App\Service\Role\RoleService;
use App\Service\Permission\PermissionService;
use App\Service\Operation\OperationService;
use Psr\Container\ContainerInterface;

$container = $app->getContainer();

$container['user_service'] = static function (ContainerInterface $container): UserService {
    return new UserService($container->get('user_repository'), $container->get('redis_service'));
};

$container['profile_service'] = static function (ContainerInterface $container): ProfileService {
    return new ProfileService($container->get('profile_repository'), $container->get('redis_service'));
};

$container['module_service'] = static function (ContainerInterface $container): ModuleService {
    return new ModuleService($container->get('module_repository'), $container->get('redis_service'));
};

$container['role_service'] = static function (ContainerInterface $container): RoleService {
    return new RoleService($container->get('role_repository'), $container->get('redis_service'));
};

$container['permission_service'] = static function (ContainerInterface $container): PermissionService {
    return new PermissionService($container->get('permission_repository'), $container->get('redis_service'));
};

$container['operation_service'] = static function (ContainerInterface $container): OperationService {
    return new OperationService($container->get('operation_repository'), $container->get('redis_service'));
};
