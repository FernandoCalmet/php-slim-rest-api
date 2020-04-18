<?php

declare(strict_types=1);

namespace App\Controller\Role;

use Slim\Http\Request;
use Slim\Http\Response;

class GetAll extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $rolees = $this->getAllRoleService()->getAll();

        return $this->jsonResponse($response, 'success', $rolees, 200);
    }
}
