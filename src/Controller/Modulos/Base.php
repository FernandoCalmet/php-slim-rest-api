<?php declare(strict_types=1);

namespace App\Controller\Modulos;

use App\Service\ModulosService;

abstract class Base
{
    protected $container;

    protected $modulosService;

    public function __construct($container)
    {
        $this->container = $container;
    }

    protected function getModulosService(): ModulosService
    {
        return $this->container->get('modulos_service');
    }
}
