<?php

declare(strict_types=1);

namespace App\Controller\Permisos;

class GetAll extends Base
{
    public function __invoke($request, $response)
    {
        $permisoss = $this->getPermisosService()->getAll();

        $payload = json_encode($permisoss);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
