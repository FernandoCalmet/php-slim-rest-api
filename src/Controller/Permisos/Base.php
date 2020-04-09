<?php

declare(strict_types=1);

namespace App\Controller\Permisos;

use App\Service\PermisosService;
use App\Controller\BaseController;
use Slim\Container;

abstract class Base extends BaseController
{
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    protected function getPermisosService(): PermisosService
    {
        return $this->container->get('permisos_service');
    }
}
