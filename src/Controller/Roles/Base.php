<?php declare(strict_types=1);

namespace App\Controller\Roles;

use App\Service\RolesService;

abstract class Base
{
    protected $container;

    protected $rolesService;

    public function __construct($container)
    {
        $this->container = $container;
    }

    protected function getRolesService(): RolesService
    {
        return $this->container->get('roles_service');
    }
}
