<?php

declare(strict_types=1);

namespace App\Controller\Roles;

class Update extends Base
{
    public function __invoke($request, $response, array $args)
    {
        $input = $request->getParsedBody();
        $roles = $this->getRolesService()->update($input, (int) $args['id']);

        $payload = json_encode($roles);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
