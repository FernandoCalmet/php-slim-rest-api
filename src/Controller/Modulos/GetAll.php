<?php

declare(strict_types=1);

namespace App\Controller\Modulos;

use Slim\Http\Request;
use Slim\Http\Response;

class GetAll extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();
        $modulos = $this->getModulosService()->getAll();

        return $this->jsonResponse($response, 'success', $modulos, 200);
    }
}
