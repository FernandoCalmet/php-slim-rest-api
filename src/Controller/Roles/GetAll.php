<?php

declare(strict_types=1);

namespace App\Controller\Roles;

class GetAll extends Base
{
    public function __invoke($request, $response)
    {
        $roless = $this->getRolesService()->getAll();

        $payload = json_encode($roless);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
