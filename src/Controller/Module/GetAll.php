<?php

declare(strict_types=1);

namespace App\Controller\Module;

use Slim\Http\Request;
use Slim\Http\Response;

class GetAll extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $modules = $this->getAllModuleService()->getAll();

        return $this->jsonResponse($response, 'success', $modules, 200);
    }
}
