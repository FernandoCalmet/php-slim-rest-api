<?php

declare(strict_types=1);

namespace App\Controller\Role;

use Slim\Http\Request;
use Slim\Http\Response;

class Delete extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $this->deleteRoleService()->delete((int) $args['id']);

        return $this->jsonResponse($response, 'success', null, 204);
    }
}
