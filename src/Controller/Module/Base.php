<?php

declare(strict_types=1);

namespace App\Controller\Module;

use App\Controller\BaseController;
use App\Service\Module\Create;
use App\Service\Module\Delete;
use App\Service\Module\GetAll;
use App\Service\Module\GetOne;
use App\Service\Module\Search;
use App\Service\Module\Update;
use Slim\Container;

abstract class Base extends BaseController
{
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    protected function createModuleService(): Create
    {
        return $this->container->get('create_module_service');
    }

    protected function deleteModuleService(): Delete
    {
        return $this->container->get('delete_module_service');
    }

    protected function getAllModuleService(): GetAll
    {
        return $this->container->get('get_all_module_service');
    }

    protected function getOneModuleService(): GetOne
    {
        return $this->container->get('get_one_module_service');
    }

    protected function SearchModuleService(): Search
    {
        return $this->container->get('search_module_service');
    }

    protected function UpdateModuleService(): Update
    {
        return $this->container->get('update_module_service');
    }
}
