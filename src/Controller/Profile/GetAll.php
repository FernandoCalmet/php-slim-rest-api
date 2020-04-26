<?php

declare(strict_types=1);

namespace App\Controller\Profile;

use Slim\Http\Request;
use Slim\Http\Response;

final class GetAll extends Base
{
    public function __invoke(Request $request, Response $response): Response
    {
        $input = $request->getParsedBody();
        $usuarioId = (int) $input['decoded']->sub;
        $profiles = $this->getProfileService()->getAll($usuarioId);

        return $this->jsonResponse($response, 'success', $profiles, 200);
    }
}
