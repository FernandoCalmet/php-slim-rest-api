<?php

declare(strict_types=1);

namespace App\Controller\Usuarios;

use Slim\Http\Request;
use Slim\Http\Response;

class Update extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();
        $userIdLogged = $input['decoded']->sub;
        $this->checkUsuarioPermissions($args['id'], $userIdLogged);
        $user = $this->getUsuariosService()->update($input, (int) $args['id']);

        return $this->jsonResponse($response, 'success', $user, 200);
    }
}
