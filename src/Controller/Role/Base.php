<?php

declare(strict_types=1);

namespace App\Controller\Role;

use App\Controller\BaseController;
use App\Service\Role\Create;
use App\Service\Role\Delete;
use App\Service\Role\GetAll;
use App\Service\Role\GetOne;
use App\Service\Role\Search;
use App\Service\Role\Update;
use Slim\Container;

abstract class Base extends BaseController
{
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    protected function createRoleService(): Create
    {
        return $this->container->get('create_role_service');
    }

    protected function deleteRoleService(): Delete
    {
        return $this->container->get('delete_role_service');
    }

    protected function getAllRoleService(): GetAll
    {
        return $this->container->get('get_all_role_service');
    }

    protected function getOneRoleService(): GetOne
    {
        return $this->container->get('get_one_role_service');
    }

    protected function SearchRoleService(): Search
    {
        return $this->container->get('search_role_service');
    }

    protected function UpdateRoleService(): Update
    {
        return $this->container->get('update_role_service');
    }
}
