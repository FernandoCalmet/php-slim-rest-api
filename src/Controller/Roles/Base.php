<?php

declare(strict_types=1);

namespace App\Controller\Roles;

use App\Service\RolesService;
use App\Controller\BaseController;
use Slim\Container;

abstract class Base extends BaseController
{
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    protected function getRolesService(): RolesService
    {
        return $this->container->get('roles_service');
    }
}
