<?php

declare(strict_types=1);

namespace App\Controller\Modulos;

class GetOne extends Base
{
    public function __invoke($request, $response, array $args)
    {
        $modulos = $this->getModulosService()->getOne((int) $args['id']);

        $payload = json_encode($modulos);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
