<?php declare(strict_types=1);

namespace App\Controller\Usuarios;

use App\Service\UsuariosService;

abstract class Base
{
    protected $container;

    protected $usuariosService;

    public function __construct($container)
    {
        $this->container = $container;
    }

    protected function getUsuariosService(): UsuariosService
    {
        return $this->container->get('usuarios_service');
    }
}
