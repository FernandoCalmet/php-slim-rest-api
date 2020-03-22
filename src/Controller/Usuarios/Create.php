<?php

declare(strict_types=1);

namespace App\Controller\Usuarios;

class Create extends Base
{
    public function __invoke($request, $response)
    {
        $input = $request->getParsedBody();
        $usuarios = $this->getUsuariosService()->create($input);

        $payload = json_encode($usuarios);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }
}
