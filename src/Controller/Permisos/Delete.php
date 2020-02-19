<?php declare(strict_types=1);

namespace App\Controller\Permisos;

class Delete extends Base
{
    public function __invoke($request, $response, array $args)
    {
        $this->getPermisosService()->deletePermisos((int) $args['id']);

        return $response->withHeader('Content-Type', 'application/json')->withStatus(204);
    }
}
