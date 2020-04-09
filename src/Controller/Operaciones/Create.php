<?php

declare(strict_types=1);

namespace App\Controller\Operaciones;

use Slim\Http\Request;
use Slim\Http\Response;

class Create extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();
        $operacion = $this->getOperacionesService()->create($input);

        return $this->jsonResponse($response, 'success', $operacion, 201);
    }
}
