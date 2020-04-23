<?php

declare(strict_types=1);

namespace App\Controller\Module;

use Slim\Http\Request;
use Slim\Http\Response;

final class Create extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();
        $module = $this->createModuleService()->create($input);

        return $this->jsonResponse($response, 'success', $module, 201);
    }
}
