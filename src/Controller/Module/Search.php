<?php

declare(strict_types=1);

namespace App\Controller\Module;

use Slim\Http\Request;
use Slim\Http\Response;

final class Search extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $modules = $this->searchModuleService()->search($args['query']);

        return $this->jsonResponse($response, 'success', $modules, 200);
    }
}
