<?php

declare(strict_types=1);

namespace App\Controller\Usuarios;

class GetOne extends Base
{
    public function __invoke($request, $response, array $args)
    {
        $usuarios = $this->getUsuariosService()->getOne((int) $args['id']);

        $payload = json_encode($usuarios);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
