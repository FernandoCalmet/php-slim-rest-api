<?php declare(strict_types=1);

namespace App\Controller\Operaciones;

class GetAll extends Base
{
    public function __invoke($request, $response)
    {
        $operacioness = $this->getOperacionesService()->getAllOperaciones();

        $payload = json_encode($operacioness);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
