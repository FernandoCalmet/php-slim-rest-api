<?php

declare(strict_types=1);

namespace App\Service\Permission;

use App\Exception\PermissionException;
use App\Repository\PermissionRepository;
use App\Service\BaseService;
use App\Service\RedisService;
use Respect\Validation\Validator as v;

abstract class Base extends BaseService
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

    protected static function validateId(int $id): int
    {
        if (!v::length(1, 11)->validate($id)) {
            throw new PermissionException('ID no valid', 400);
        }
        return $id;
    } 
   
    protected function getOneFromCache(int $permissionId)
    {
        $redisKey = sprintf(self::REDIS_KEY, $permissionId);
        $key = $this->redisService->generateKey($redisKey);
        if ($this->redisService->exists($key)) {
            $permission = $this->redisService->get($key);
        } else {
            $permission = $this->getOneFromDb($permissionId);
            $this->redisService->setex($key, $permission);
        }

        return $permission;
    }

    protected function getOneFromDb(int $permissionId)
    {
        return $this->permissionRepository->checkAndGetPermission($permissionId);
    }

    protected function saveInCache($id, $permission): void
    {
        $redisKey = sprintf(self::REDIS_KEY, $id);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->setex($key, $permission);
    }

    protected function deleteFromCache($permissionId): void
    {
        $redisKey = sprintf(self::REDIS_KEY, $permissionId);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->del($key);
    }
}
