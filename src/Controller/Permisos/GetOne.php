<?php

declare(strict_types=1);

namespace App\Controller\Permisos;

use Slim\Http\Request;
use Slim\Http\Response;

class GetOne extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();
        $permisoId = (int) $args['id'];
        $permiso = $this->getPermisosService()->getOne($permisoId);

        return $this->jsonResponse($response, 'success', $permiso, 200);
    }
}
