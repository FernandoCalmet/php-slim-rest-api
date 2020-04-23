<?php

declare(strict_types=1);

namespace App\Service\Permission;

final class GetOne extends BasePermissionService
{
    public function getOne(int $permissionId)
    {
        if (self::isRedisEnabled() === true) {
            $permission = $this->getOneFromCache($permissionId);
        } else {
            $permission = $this->getOneFromDb($permissionId);
        }

        return $permission;
    }

    public function getOneFromCache(int $permissionId)
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
}
