<?php

declare(strict_types=1);

namespace App\Controller\Permisos;

use Slim\Http\Request;
use Slim\Http\Response;

class GetAll extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();
        $permisos = $this->getPermisosService()->getAll();

        return $this->jsonResponse($response, 'success', $permisos, 200);
    }
}
