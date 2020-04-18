<?php

declare(strict_types=1);

namespace App\Controller\Profile;

use Slim\Http\Request;
use Slim\Http\Response;

class Delete extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();
        $profileId = (int) $args['id'];
        $usuarioId = (int) $input['decoded']->sub;
        $profile = $this->getProfileService()->delete($profileId, $usuarioId);

        return $this->jsonResponse($response, 'success', $profile, 204);
    }
}
