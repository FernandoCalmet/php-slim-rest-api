<?php

declare(strict_types=1);

namespace App\Controller\User;

use Slim\Http\Request;
use Slim\Http\Response;

final class Search extends Base
{
    /**
     * @param array<string> $args
     */
    public function __invoke(
        Request $request,
        Response $response,
        array $args
    ): Response {
        $users = $this->getServiceFindUser()->search($args['query']);

        return $this->jsonResponse($response, 'success', $users, 200);
    }
}
