<?php

declare(strict_types=1);

namespace App\Controller\Operation;

use App\Controller\BaseController;
use App\Service\Operation\Create;
use App\Service\Operation\Delete;
use App\Service\Operation\GetAll;
use App\Service\Operation\GetOne;
use App\Service\Operation\Search;
use App\Service\Operation\Update;
use Slim\Container;

abstract class Base extends BaseController
{
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    protected function createOperationService(): Create
    {
        return $this->container->get('create_operation_service');
    }

    protected function deleteOperationService(): Delete
    {
        return $this->container->get('delete_operation_service');
    }

    protected function getAllOperationService(): GetAll
    {
        return $this->container->get('get_all_operation_service');
    }

    protected function getOneOperationService(): GetOne
    {
        return $this->container->get('get_one_operation_service');
    }

    protected function SearchOperationService(): Search
    {
        return $this->container->get('search_operation_service');
    }

    protected function UpdateOperationService(): Update
    {
        return $this->container->get('update_operation_service');
    }
}
