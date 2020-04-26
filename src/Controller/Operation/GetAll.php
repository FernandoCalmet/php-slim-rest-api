<?php

declare(strict_types=1);

namespace App\Controller\Operation;

use Slim\Http\Request;
use Slim\Http\Response;

final class GetAll extends Base
{
    public function __invoke(Request $request, Response $response): Response
    {
        $operations = $this->getOperationService()->getAll();

        return $this->jsonResponse($response, 'success', $operations, 200);
    }
}
