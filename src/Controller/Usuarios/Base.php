<?php

declare(strict_types=1);

namespace App\Controller\Usuarios;

use App\Service\UsuariosService;
use App\Exception\UsuariosException;
use App\Controller\BaseController;
use Slim\Container;

abstract class Base extends BaseController
{   
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    protected function getUsuariosService(): UsuariosService
    {
        return $this->container->get('usuarios_service');
    }

    protected function checkUsuarioPermissions($usuarioId, $usuarioIdLogged)
    {
        if ($usuarioId != $usuarioIdLogged) {
            throw new UsuariosException('Permisos para usuarios denegados.', 400);
        }
    }
}
