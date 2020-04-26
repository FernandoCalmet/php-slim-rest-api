<?php

declare(strict_types=1);

namespace App\Controller\Operation;

use Slim\Http\Request;
use Slim\Http\Response;

final class Create extends Base
{
    public function __invoke(Request $request, Response $response): Response
    {
        $input = $request->getParsedBody();
        $operation = $this->getOperationService()->create($input);

        return $this->jsonResponse($response, 'success', $operation, 201);
    }
}
