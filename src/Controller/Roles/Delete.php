<?php

declare(strict_types=1);

namespace App\Controller\Roles;

use Slim\Http\Request;
use Slim\Http\Response;

class Delete extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();
        $rolId = (int) $args['id'];
        $rol = $this->getRolesService()->delete($rolId);

        return $this->jsonResponse($response, 'success', $rol, 204);
    }
}
