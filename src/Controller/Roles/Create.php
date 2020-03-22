<?php

declare(strict_types=1);

namespace App\Controller\Roles;

class Create extends Base
{
    public function __invoke($request, $response)
    {
        $input = $request->getParsedBody();
        $roles = $this->getRolesService()->create($input);

        $payload = json_encode($roles);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }
}
