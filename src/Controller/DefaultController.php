<?php declare(strict_types=1);

namespace App\Controller;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class DefaultController extends BaseController
{
    const API_VERSION = '0.3.0';

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getHelp(Request $request, Response $response, array $args): Response
    {
        $url = getenv('APP_DOMAIN');
        $endpoints = [
            'usuarios' => $url . '/api/v1/usuarios',
            'roles' => $url . '/api/v1/roles',            
            'permisos' => $url . '/api/v1/permisos',
            'operaciones' => $url . '/api/v1/operaciones',
            'modulos' => $url . '/api/v1/modulos',
            'docs' => $url . '/docs/index.html',
            'status' => $url . '/status',
            'this help' => $url . '',
        ];
        $message = [
            'endpoints' => $endpoints,
            'version' => self::API_VERSION,
            'timestamp' => time(),
        ];

        return $this->jsonResponse($response, 'success', $message, 200);
    }

    public function getStatus(Request $request, Response $response, array $args): Response
    {
        $status = [
            'stats' => $this->getDbStats(),
            'MySQL' => 'OK',
            'Redis' => $this->checkRedisConnection(),
            'version' => self::API_VERSION,
            'timestamp' => time(),
        ];

        return $this->jsonResponse($response, 'success', $status, 200);
    }

    private function getDbStats(): array
    {
        $usuariosService = $this->container->get('usuarios_service');
        $rolesService = $this->container->get('roles_service');      
        $permisosService = $this->container->get('permisos_service');
        $operacionesService = $this->container->get('operaciones_service');
        $modulosService = $this->container->get('modulos_service');

        return [
            'usuarios' => count($usuariosService->getAll()),
            'roles' => count($rolesService->getAll()),           
            'permisos' => count($permisosService->getAll()),
            'operaciones' => count($operacionesService->getAll()),
            'modulos' => count($modulosService->getAll())     
        ];
    }

    private function checkRedisConnection(): string
    {
        $redis = 'Disabled';
        if (self::isRedisEnabled() === true) {
            $redisService = $this->container->get('redis_service');
            $redisKey = 'test:status';
            $key = $redisService->generateKey($redisKey);
            $redisService->set($key, []);
            $redis = 'OK';
        }

        return $redis;
    }
}
