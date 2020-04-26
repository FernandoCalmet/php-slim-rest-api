<?php

declare(strict_types=1);

namespace App\Controller\Module;

use Slim\Http\Request;
use Slim\Http\Response;

final class Create extends Base
{
    public function __invoke(Request $request, Response $response): Response
    {
        $input = $request->getParsedBody();
        $module = $this->getModuleService()->create($input);

        return $this->jsonResponse($response, 'success', $module, 201);
    }
}
