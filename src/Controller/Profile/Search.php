<?php

declare(strict_types=1);

namespace App\Controller\Profile;

use Slim\Http\Request;
use Slim\Http\Response;

class Search extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();
        $usuarioId = (int) $input['decoded']->sub;
        $query = '';
        if (isset($args['query'])) {
            $query = $args['query'];
        }
        $status = $request->getParam('status', null);
        $profiles = $this->getProfileService()->search($query, $usuarioId, $status);

        return $this->jsonResponse($response, 'success', $profiles, 200);
    }
}
