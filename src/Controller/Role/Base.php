<?php

declare(strict_types=1);

namespace App\Controller\Role;

use App\Controller\BaseController;
use App\Service\Role\RoleService;
use Slim\Container;

abstract class Base extends BaseController
{
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    protected function getRoleService(): RoleService
    {
        return $this->container->get('role_service');
    }   
}
