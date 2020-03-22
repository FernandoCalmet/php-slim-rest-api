<?php

declare(strict_types=1);

namespace App\Controller\Modulos;

class Create extends Base
{
    public function __invoke($request, $response)
    {
        $input = $request->getParsedBody();
        $modulos = $this->getModulosService()->create($input);

        $payload = json_encode($modulos);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }
}
