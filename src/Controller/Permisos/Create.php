<?php declare(strict_types=1);

namespace App\Controller\Permisos;

class Create extends Base
{
    public function __invoke($request, $response)
    {
        $input = $request->getParsedBody();
        $permisos = $this->getPermisosService()->createPermisos($input);

        $payload = json_encode($permisos);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }
}
