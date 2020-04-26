<?php

declare(strict_types=1);

namespace App\Controller\Module;

use Slim\Http\Request;
use Slim\Http\Response;

final class GetAll extends Base
{
    public function __invoke(Request $request, Response $response): Response
    {
        $modules = $this->getModuleService()->getAll();

        return $this->jsonResponse($response, 'success', $modules, 200);
    }
}
