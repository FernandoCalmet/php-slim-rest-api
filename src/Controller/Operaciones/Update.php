<?php

declare(strict_types=1);

namespace App\Controller\Operaciones;

class Update extends Base
{
    public function __invoke($request, $response, array $args)
    {
        $input = $request->getParsedBody();
        $operaciones = $this->getOperacionesService()->update($input, (int) $args['id']);

        $payload = json_encode($operaciones);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
