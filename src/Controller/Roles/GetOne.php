<?php

declare(strict_types=1);

namespace App\Controller\Roles;

use Slim\Http\Request;
use Slim\Http\Response;

class GetOne extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();
        $rolId = (int) $args['id'];
        $rol = $this->getRolesService()->getOne($rolId);

        return $this->jsonResponse($response, 'success', $rol, 200);
    }
}
