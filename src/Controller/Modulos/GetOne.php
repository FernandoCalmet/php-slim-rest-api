<?php

declare(strict_types=1);

namespace App\Controller\Modulos;

use Slim\Http\Request;
use Slim\Http\Response;

class GetOne extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();
        $moduloId = (int) $args['id'];
        $modulo = $this->getModulosService()->getOne($moduloId);

        return $this->jsonResponse($response, 'success', $modulo, 200);
    }
}
