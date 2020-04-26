<?php

declare(strict_types=1);

namespace App\Controller\Operation;

use App\Controller\BaseController;
use App\Service\Operation\OperationService;
use Slim\Container;

abstract class Base extends BaseController
{
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    protected function getOperationService(): OperationService
    {
        return $this->container->get('operation_service');
    }
}
