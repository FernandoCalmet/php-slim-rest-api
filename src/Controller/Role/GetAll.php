<?php

declare(strict_types=1);

namespace App\Controller\Role;

use Slim\Http\Request;
use Slim\Http\Response;

final class GetAll extends Base
{
    public function __invoke(Request $request, Response $response): Response
    {
        $roles = $this->getRoleService()->getAll();

        return $this->jsonResponse($response, 'success', $roles, 200);
    }
}
