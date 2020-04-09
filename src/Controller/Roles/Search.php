<?php declare(strict_types=1);

namespace App\Controller\Roles;

use Slim\Http\Request;
use Slim\Http\Response;

class Search extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $input = $request->getParsedBody();
        $query = '';
        if (isset($args['query'])) {
            $query = $args['query'];
        }   
        $roles = $this->getRolesService()->search($query);

        return $this->jsonResponse($response, 'success', $roles, 200);
    }
}
