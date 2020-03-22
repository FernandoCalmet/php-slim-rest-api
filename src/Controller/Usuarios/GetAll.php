<?php

declare(strict_types=1);

namespace App\Controller\Usuarios;

class GetAll extends Base
{
    public function __invoke($request, $response)
    {
        $usuarioss = $this->getUsuariosService()->getAll();

        $payload = json_encode($usuarioss);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
