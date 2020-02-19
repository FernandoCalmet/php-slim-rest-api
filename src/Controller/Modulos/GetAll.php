<?php declare(strict_types=1);

namespace App\Controller\Modulos;

class GetAll extends Base
{
    public function __invoke($request, $response)
    {
        $moduloss = $this->getModulosService()->getAllModulos();

        $payload = json_encode($moduloss);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
