<?php

declare(strict_types=1);

namespace App\Controller\Modulos;

use Slim\Http\Request;
use Slim\Http\Response;

class Update extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();
        $modulo = $this->getModulosService()->update($input, (int) $args['id']);

        return $this->jsonResponse($response, 'success', $modulo, 200);
    }
}
