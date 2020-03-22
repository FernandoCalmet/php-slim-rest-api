<?php declare(strict_types=1);

namespace App\Controller\Operaciones;

use Slim\Http\Request;
use Slim\Http\Response;

class Search extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $operaciones = $this->getOperacionesService()->search($args['query']);

        $payload = json_encode($operaciones);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
