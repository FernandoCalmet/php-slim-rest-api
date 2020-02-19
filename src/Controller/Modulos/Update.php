<?php declare(strict_types=1);

namespace App\Controller\Modulos;

class Update extends Base
{
    public function __invoke($request, $response, array $args)
    {
        $input = $request->getParsedBody();
        $modulos = $this->getModulosService()->updateModulos($input, (int) $args['id']);

        $payload = json_encode($modulos);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
