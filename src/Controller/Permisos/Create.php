<?php

declare(strict_types=1);

namespace App\Controller\Permisos;

use Slim\Http\Request;
use Slim\Http\Response;

class Create extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();
        $permiso = $this->getPermisosService()->create($input);

        return $this->jsonResponse($response, 'success', $permiso, 201);
    }
}
