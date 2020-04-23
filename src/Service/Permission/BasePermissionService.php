<?php

declare(strict_types=1);

namespace App\Service\Permission;

use App\Service\BaseService;
use App\Service\RedisService;
use App\Repository\PermissionRepository;

abstract class BasePermissionService extends BaseService
{
    private const REDIS_KEY = 'permission:%s';

    /**
     * @var PermissionRepository
     */
    protected $permissionRepository;

    /**
     * @var RedisService
     */
    protected $redisService;

    public function __construct(PermissionRepository $permissionRepository, RedisService $redisService)
    {
        $this->permissionRepository = $permissionRepository;
        $this->redisService = $redisService;
    }

    public function getOneFromDb(int $permissionId)
    {
        return $this->permissionRepository->checkAndGetPermission($permissionId);
    }

    public function saveInCache($id, $permission): void
    {
        $redisKey = sprintf(self::REDIS_KEY, $id);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->setex($key, $permission);
    }

    public function deleteFromCache($permissionId): void
    {
        $redisKey = sprintf(self::REDIS_KEY, $permissionId);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->del($key);
    }
}
