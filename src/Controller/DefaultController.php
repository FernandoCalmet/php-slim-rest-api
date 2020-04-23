<?php

declare(strict_types=1);

namespace App\Controller;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

final class DefaultController extends BaseController
{
    const API_VERSION = '1.1.0';

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getHelp(Request $request, Response $response): Response
    {
        $url = getenv('APP_DOMAIN');
        $endpoints = [
            'this help' => $url . '',     
            'docs' => $url . '/docs/index.html',       
            'status' => $url . '/status',            
            'profiles' => $url . '/api/v1/profiles',
            'users' => $url . '/api/v1/users',
            'modules' => $url . '/api/v1/modules',
            'operations' => $url . '/api/v1/operations',
            'permissions' => $url . '/api/v1/permissions',
            'roles' => $url . '/api/v1/roles',
        ];
        $message = [
            'endpoints' => $endpoints,
            'version' => self::API_VERSION,
            'timestamp' => time(),
        ];

        return $this->jsonResponse($response, 'success', $message, 200);
    }

    public function getStatus(Request $request, Response $response): Response
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
        $userService = $this->container->get('user_service');
        $profileService = $this->container->get('profile_service');
        $moduleService = $this->container->get('get_all_module_service');
        $operationService = $this->container->get('get_all_operation_service');
        $permissionService = $this->container->get('get_all_permission_service');
        $roleService = $this->container->get('get_all_role_service');        

        return [
            'users' => count($userService->getAll()),
            'profiles' => count($profileService->getAllProfiles()),
            'modules' => count($moduleService->getAll()),
            'operations' => count($operationService->getAll()),
            'permissions' => count($permissionService->getAll()),
            'roles' => count($roleService->getAll())
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
