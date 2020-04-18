<?php

declare(strict_types=1);

namespace App\Service\Role;

use App\Service\BaseService;
use App\Service\RedisService;
use App\Repository\RoleRepository;

abstract class BaseRoleService extends BaseService
{
    const REDIS_KEY = 'role:%s';

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

    public function getOneFromDb(int $roleId)
    {
        return $this->roleRepository->checkAndGetRole($roleId);
    }

    public function saveInCache($id, $role)
    {
        $redisKey = sprintf(self::REDIS_KEY, $id);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->setex($key, $role);
    }

    public function deleteFromCache($roleId)
    {
        $redisKey = sprintf(self::REDIS_KEY, $roleId);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->del($key);
    }
}
