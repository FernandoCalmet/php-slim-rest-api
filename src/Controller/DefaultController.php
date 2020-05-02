<?php

declare(strict_types=1);

namespace App\Controller;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

final class DefaultController extends BaseController
{
    const API_VERSION = '1.4.0';

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
        $moduleService = $this->container->get('module_service');
        $operationService = $this->container->get('operation_service');
        $permissionService = $this->container->get('permission_service');
        $roleService = $this->container->get('role_service');        

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

    public static function postCreateProjectCommand(): void
    {
        $version = self::API_VERSION;
        $str = <<<EOF
                _                 _     
               | |               (_)    
  _ __ ___  ___| |_    __ _ _ __  _     
 | '__/ _ \/ __| __|  / _` | '_ \| |    
 | | |  __/\__ \ |_  | (_| | |_) | |    
 |_|  \___||___/\__|  \__,_| .__/|_|    
                           | |          
      _ _                  |_|          
     | (_)                 | |          
  ___| |_ _ __ ___    _ __ | |__  _ __  
 / __| | | '_ ` _ \  | '_ \| '_ \| '_ \ 
 \__ \ | | | | | | | | |_) | | | | |_) |
 |___/_|_|_| |_| |_| | .__/|_| |_| .__/ 
                     | |         | |    
                     |_|         |_|    

[Version: ${version}]

Successfully created project!

Get started with the following commands:

$ cd [my-api-name]
$ composer restart-db
$ composer test
$ composer start

(P.S. set your MySQL connection in .env file)

Thanks for installing this project!

Now go build a cool RESTful API ;-)

EOF;
        echo $str;
    }
}
