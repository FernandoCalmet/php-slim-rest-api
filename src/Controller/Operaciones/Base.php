<?php declare(strict_types=1);

namespace App\Controller\Operaciones;

use App\Service\OperacionesService;

abstract class Base
{
    protected $container;

    protected $operacionesService;

    public function __construct($container)
    {
        $this->container = $container;
    }

    protected function getOperacionesService(): OperacionesService
    {
        return $this->container->get('operaciones_service');
    }
}
