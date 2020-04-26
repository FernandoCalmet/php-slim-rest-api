<?php

declare(strict_types=1);

namespace App\Controller\Permission;

use App\Controller\BaseController;
use App\Service\Permission\PermissionService;
use Slim\Container;

abstract class Base extends BaseController
{
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    protected function getPermissionService(): Permission
    {
        return $this->container->get('permission_service');
    }
}
