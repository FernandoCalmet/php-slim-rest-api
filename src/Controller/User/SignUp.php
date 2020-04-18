<?php

declare(strict_types=1);

namespace App\Controller\User;

use Slim\Http\Request;
use Slim\Http\Response;

class SignUp extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();
        $user = $this->getUserService()->signup($input);

        return $this->jsonResponse($response, 'success', $user, 201);
    }
}
