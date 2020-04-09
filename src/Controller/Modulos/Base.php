<?php

declare(strict_types=1);

namespace App\Controller\Modulos;

use App\Service\ModulosService;
use App\Controller\BaseController;
use Slim\Container;

abstract class Base extends BaseController
{
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    protected function getModulosService(): ModulosService
    {
        return $this->container->get('modulos_service');
    }
}
