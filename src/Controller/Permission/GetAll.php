<?php

declare(strict_types=1);

namespace App\Controller\Permission;

use Slim\Http\Request;
use Slim\Http\Response;

final class GetAll extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $permissions = $this->getAllPermissionService()->getAll();

        return $this->jsonResponse($response, 'success', $permissions, 200);
    }
}
