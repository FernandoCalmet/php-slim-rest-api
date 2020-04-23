<?php

declare(strict_types=1);

namespace App\Controller\Role;

use Slim\Http\Request;
use Slim\Http\Response;

final class Update extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();
        $role = $this->updateRoleService()->update($input, (int) $args['id']);

        return $this->jsonResponse($response, 'success', $role, 200);
    }
}
