<?php

declare(strict_types=1);

namespace App\Controller\Permission;

use Slim\Http\Request;
use Slim\Http\Response;

final class Create extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();
        $permission = $this->createPermissionService()->create($input);

        return $this->jsonResponse($response, 'success', $permission, 201);
    }
}
