<?php

declare(strict_types=1);

namespace App\Controller\Profile;

use Slim\Http\Request;
use Slim\Http\Response;

class Create extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();
        $profile = $this->getProfileService()->create($input);

        return $this->jsonResponse($response, 'success', $profile, 201);
    }
}
