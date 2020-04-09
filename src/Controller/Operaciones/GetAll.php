<?php

declare(strict_types=1);

namespace App\Controller\Operaciones;

use Slim\Http\Request;
use Slim\Http\Response;

class GetAll extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();
        $operaciones = $this->getOperacionesService()->getAll();

        return $this->jsonResponse($response, 'success', $operaciones, 200);
    }
}
