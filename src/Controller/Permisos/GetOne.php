<?php

declare(strict_types=1);

namespace App\Controller\Permisos;

class GetOne extends Base
{
    public function __invoke($request, $response, array $args)
    {
        $permisos = $this->getPermisosService()->getOne((int) $args['id']);

        $payload = json_encode($permisos);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
