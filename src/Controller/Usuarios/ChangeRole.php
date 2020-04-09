<?php

declare(strict_types=1);

namespace App\Controller\Usuarios;

use Slim\Http\Request;
use Slim\Http\Response;

class ChangeRole extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();
        $usuarioIdLogged = $input['decoded']->sub;
        $this->checkUsuarioPermissions($args['id'], $usuarioIdLogged);
        $usuario = $this->getUsuariosService()->changeRole($input, (int) $args['id']);

        return $this->jsonResponse($response, 'success', $usuario, 200);
    }
}
