<?php

declare(strict_types=1);

namespace App\Controller\Permisos;

use App\Service\PermisosService;

abstract class Base
{
    protected $container;

    protected $permisosService;

    public function __construct($container)
    {
        $this->container = $container;
    }

    protected function getPermisosService(): PermisosService
    {
        return $this->container->get('permisos_service');
    }
}
