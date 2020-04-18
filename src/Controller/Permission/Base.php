<?php

declare(strict_types=1);

namespace App\Controller\Permission;

use App\Controller\BaseController;
use App\Service\Permission\Create;
use App\Service\Permission\Delete;
use App\Service\Permission\GetAll;
use App\Service\Permission\GetOne;
use App\Service\Permission\Search;
use App\Service\Permission\Update;
use Slim\Container;

abstract class Base extends BaseController
{
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    protected function createPermissionService(): Create
    {
        return $this->container->get('create_permission_service');
    }

    protected function deletePermissionService(): Delete
    {
        return $this->container->get('delete_permission_service');
    }

    protected function getAllPermissionService(): GetAll
    {
        return $this->container->get('get_all_permission_service');
    }

    protected function getOnePermissionService(): GetOne
    {
        return $this->container->get('get_one_permission_service');
    }

    protected function SearchPermissionService(): Search
    {
        return $this->container->get('search_permission_service');
    }

    protected function UpdatePermissionService(): Update
    {
        return $this->container->get('update_permission_service');
    }
}
