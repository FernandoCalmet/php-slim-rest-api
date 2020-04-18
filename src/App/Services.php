<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use App\Service\UserService;
use App\Service\ProfileService;

$container = $app->getContainer();

$container['user_service'] = function (ContainerInterface $container): UserService {
    return new UserService($container->get('user_repository'), $container->get('redis_service'));
};

$container['profile_service'] = function (ContainerInterface $container): ProfileService {
    return new ProfileService($container->get('profile_repository'), $container->get('redis_service'));
};

$container['create_module_service'] = function (ContainerInterface $container): App\Service\Module\Create {
    return new App\Service\Module\Create($container->get('module_repository'), $container->get('redis_service'));
};
$container['delete_module_service'] = function (ContainerInterface $container): App\Service\Module\Delete {
    return new App\Service\Module\Delete($container->get('module_repository'), $container->get('redis_service'));
};
$container['get_all_module_service'] = function (ContainerInterface $container): App\Service\Module\GetAll {
    return new App\Service\Module\GetAll($container->get('module_repository'), $container->get('redis_service'));
};
$container['get_one_module_service'] = function (ContainerInterface $container): App\Service\Module\GetOne {
    return new App\Service\Module\GetOne($container->get('module_repository'), $container->get('redis_service'));
};
$container['search_module_service'] = function (ContainerInterface $container): App\Service\Module\Search {
    return new App\Service\Module\Search($container->get('module_repository'), $container->get('redis_service'));
};
$container['update_module_service'] = function (ContainerInterface $container): App\Service\Module\Update {
    return new App\Service\Module\Update($container->get('module_repository'), $container->get('redis_service'));
};

$container['create_role_service'] = function (ContainerInterface $container): App\Service\Role\Create {
    return new App\Service\Role\Create($container->get('role_repository'), $container->get('redis_service'));
};
$container['delete_role_service'] = function (ContainerInterface $container): App\Service\Role\Delete {
    return new App\Service\Role\Delete($container->get('role_repository'), $container->get('redis_service'));
};
$container['get_all_role_service'] = function (ContainerInterface $container): App\Service\Role\GetAll {
    return new App\Service\Role\GetAll($container->get('role_repository'), $container->get('redis_service'));
};
$container['get_one_role_service'] = function (ContainerInterface $container): App\Service\Role\GetOne {
    return new App\Service\Role\GetOne($container->get('role_repository'), $container->get('redis_service'));
};
$container['search_role_service'] = function (ContainerInterface $container): App\Service\Role\Search {
    return new App\Service\Role\Search($container->get('role_repository'), $container->get('redis_service'));
};
$container['update_role_service'] = function (ContainerInterface $container): App\Service\Role\Update {
    return new App\Service\Role\Update($container->get('role_repository'), $container->get('redis_service'));
};

$container['create_permission_service'] = function (ContainerInterface $container): App\Service\Permission\Create {
    return new App\Service\Permission\Create($container->get('permission_repository'), $container->get('redis_service'));
};
$container['delete_permission_service'] = function (ContainerInterface $container): App\Service\Permission\Delete {
    return new App\Service\Permission\Delete($container->get('permission_repository'), $container->get('redis_service'));
};
$container['get_all_permission_service'] = function (ContainerInterface $container): App\Service\Permission\GetAll {
    return new App\Service\Permission\GetAll($container->get('permission_repository'), $container->get('redis_service'));
};
$container['get_one_permission_service'] = function (ContainerInterface $container): App\Service\Permission\GetOne {
    return new App\Service\Permission\GetOne($container->get('permission_repository'), $container->get('redis_service'));
};
$container['search_permission_service'] = function (ContainerInterface $container): App\Service\Permission\Search {
    return new App\Service\Permission\Search($container->get('permission_repository'), $container->get('redis_service'));
};
$container['update_permission_service'] = function (ContainerInterface $container): App\Service\Permission\Update {
    return new App\Service\Permission\Update($container->get('permission_repository'), $container->get('redis_service'));
};

$container['create_operation_service'] = function (ContainerInterface $container): App\Service\Operation\Create {
    return new App\Service\Operation\Create($container->get('operation_repository'), $container->get('redis_service'));
};
$container['delete_operation_service'] = function (ContainerInterface $container): App\Service\Operation\Delete {
    return new App\Service\Operation\Delete($container->get('operation_repository'), $container->get('redis_service'));
};
$container['get_all_operation_service'] = function (ContainerInterface $container): App\Service\Operation\GetAll {
    return new App\Service\Operation\GetAll($container->get('operation_repository'), $container->get('redis_service'));
};
$container['get_one_operation_service'] = function (ContainerInterface $container): App\Service\Operation\GetOne {
    return new App\Service\Operation\GetOne($container->get('operation_repository'), $container->get('redis_service'));
};
$container['search_operation_service'] = function (ContainerInterface $container): App\Service\Operation\Search {
    return new App\Service\Operation\Search($container->get('operation_repository'), $container->get('redis_service'));
};
$container['update_operation_service'] = function (ContainerInterface $container): App\Service\Operation\Update {
    return new App\Service\Operation\Update($container->get('operation_repository'), $container->get('redis_service'));
};
