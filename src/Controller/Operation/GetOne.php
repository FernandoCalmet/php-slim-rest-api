<?php

declare(strict_types=1);

namespace App\Controller\Operation;

use Slim\Http\Request;
use Slim\Http\Response;

final class GetOne extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $operation = $this->getOneOperationService()->getOne((int) $args['id']);

        return $this->jsonResponse($response, 'success', $operation, 200);
    }
}
