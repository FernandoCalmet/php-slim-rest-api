<?php

declare(strict_types=1);

namespace App\Controller\Operation;

use Slim\Http\Request;
use Slim\Http\Response;

final class Update extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();
        $operation = $this->updateOperationService()->update($input, (int) $args['id']);

        return $this->jsonResponse($response, 'success', $operation, 200);
    }
}