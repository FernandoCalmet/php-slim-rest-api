<?php

declare(strict_types=1);

namespace App\Service\Role;

use App\Exception\RoleException;
use App\Repository\RoleRepository;
use App\Service\BaseService;
use App\Service\RedisService;
use Respect\Validation\Validator as v;

abstract class Base extends BaseService
{
    private const REDIS_KEY = 'role:%s';

    /**
     * @var RoleRepository
     */
    protected $roleRepository;

    /**
     * @var RedisService
     */
    protected $redisService;

    public function __construct(RoleRepository $roleRepository, RedisService $redisService)
    {
        $this->roleRepository = $roleRepository;
        $this->redisService = $redisService;
    }

    protected static function validateRoleName(string $name): string
    {
        if (!v::length(2, 50)->validate($name)) {
            throw new RoleException('The name of the role is invalid.', 400);
        }

        return $name;
    }

    protected static function validateDescription(string $description): string
    {
        if (!v::stringType()->length(2, 200)->validate($description)) {
            throw new RoleException('Description no valid.', 400);
        }
        return $description;
    }    

    protected function getOneFromCache(int $roleId)
    {
        $redisKey = sprintf(self::REDIS_KEY, $roleId);
        $key = $this->redisService->generateKey($redisKey);
        if ($this->redisService->exists($key)) {
            $role = $this->redisService->get($key);
        } else {
            $role = $this->getOneFromDb($roleId);
            $this->redisService->setex($key, $role);
        }

        return $role;
    }

    protected function getOneFromDb(int $roleId)
    {
        return $this->roleRepository->checkAndGetRole($roleId);
    }

    protected function saveInCache($id, $role): void
    {
        $redisKey = sprintf(self::REDIS_KEY, $id);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->setex($key, $role);
    }

    protected function deleteFromCache($roleId): void
    {
        $redisKey = sprintf(self::REDIS_KEY, $roleId);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->del($key);
    }
}
