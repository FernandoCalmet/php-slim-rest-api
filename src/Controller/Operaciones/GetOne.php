<?php

declare(strict_types=1);

namespace App\Controller\Operaciones;

use Slim\Http\Request;
use Slim\Http\Response;

class GetOne extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();
        $operacionId = (int) $args['id'];
        $operacion = $this->getOperacionesService()->getOne($operacionId);

        return $this->jsonResponse($response, 'success', $operacion, 200);
    }
}
