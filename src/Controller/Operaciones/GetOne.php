<?php declare(strict_types=1);

namespace App\Controller\Operaciones;

class GetOne extends Base
{
    public function __invoke($request, $response, array $args)
    {
        $operaciones = $this->getOperacionesService()->getOperaciones((int) $args['id']);

        $payload = json_encode($operaciones);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
