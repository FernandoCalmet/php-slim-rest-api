<?php

declare(strict_types=1);

namespace Tests\unit\Service;

use Tests\integration\BaseTestCase;

class UserServiceTest extends BaseTestCase
{
    /**
     * @var int
     */
    private static $id;

    private function getDatabase(): \PDO
    {
        $database = sprintf('mysql:host=%s;dbname=%s', getenv('DB_HOSTNAME'), getenv('DB_DATABASE'));

        return new \PDO($database, getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
    }

    public function testGetUser(): void
    {
        $userRepository = new \App\Repository\UserRepository($this->getDatabase());
        $redisService = new \App\Service\RedisService(new \Predis\Client());
        $userService = new \App\Service\UserService($userRepository, $redisService);
        $user = $userService->getOne(1);
        $this->assertStringContainsString('Fernando', $user->first_name);
    }

    public function testCreateUser(): void
    {
        $userRepository = new \App\Repository\UserRepository($this->getDatabase());
        $redisService = new \App\Service\RedisService(new \Predis\Client());
        $userService = new \App\Service\UserService($userRepository, $redisService);
        $input = [            
            'email' => 'tester@gmail.com', 
            'password' => 'AnyPass1000',
            'first_name' => 'Fernando',
            'last_name' => 'Calmet',
            'gender' => 'male',
            'birthday' => '1989-1-1'
        ];
        $user = $userService->create($input);
        self::$id = $user->id;
        $this->assertStringContainsString('Fernando', $user->first_name);
    }

    public function testCreateUserWithoutNameExpectError(): void
    {
        $this->expectException(\App\Exception\User::class);

        $userRepository = new \App\Repository\UserRepository($this->getDatabase());
        $redisService = new \App\Service\RedisService(new \Predis\Client());
        $userService = new \App\Service\UserService($userRepository, $redisService);
        $input = [          
            'Fernando' => 'tester@gmail.com', 
            'password' => 'AnyPass1000',
            'first_name' => 'Fernando',
            'last_name' => 'Calmet',
            'gender' => 'male',
            'birthday' => '1989-1-1'
        ];
        $user = $userService->create($input);
        self::$id = $user->id;
        $this->assertStringContainsString('Fernando', $user->first_name);
    }

    public function testDeleteUser(): void
    {
        $userRepository = new \App\Repository\UserRepository($this->getDatabase());
        $redisService = new \App\Service\RedisService(new \Predis\Client());
        $userService = new \App\Service\UserService($userRepository, $redisService);
        $userId = self::$id;
        $user = $userService->delete((int) $userId);
        $this->assertStringContainsString('User was successfully removed.', $user);
    }
}
