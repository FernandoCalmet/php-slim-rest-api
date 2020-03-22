<?php

declare(strict_types=1);

namespace App\Controller\Permisos;

class Update extends Base
{
    public function __invoke($request, $response, array $args)
    {
        $input = $request->getParsedBody();
        $permisos = $this->getPermisosService()->update($input, (int) $args['id']);

        $payload = json_encode($permisos);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
