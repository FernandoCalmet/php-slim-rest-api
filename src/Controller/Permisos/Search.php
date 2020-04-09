<?php declare(strict_types=1);

namespace App\Controller\Permisos;

use Slim\Http\Request;
use Slim\Http\Response;

class Search extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();
        $query = '';
        if (isset($args['query'])) {
            $query = $args['query'];
        }   
        $permisos = $this->getPermisosService()->search($query);

        return $this->jsonResponse($response, 'success', $permisos, 200);
    }
}
