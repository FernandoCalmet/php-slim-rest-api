<?php

declare(strict_types=1);

namespace App\Controller\Operaciones;

use App\Service\OperacionesService;
use App\Controller\BaseController;
use Slim\Container;

abstract class Base extends BaseController
{
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    protected function getOperacionesService(): OperacionesService
    {
        return $this->container->get('operaciones_service');
    }
}
