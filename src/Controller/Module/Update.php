<?php

declare(strict_types=1);

namespace App\Controller\Module;

use Slim\Http\Request;
use Slim\Http\Response;

class Update extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();
        $module = $this->updateModuleService()->update($input, (int) $args['id']);

        return $this->jsonResponse($response, 'success', $module, 200);
    }
}
