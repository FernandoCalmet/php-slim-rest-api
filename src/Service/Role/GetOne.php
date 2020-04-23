<?php

declare(strict_types=1);

namespace App\Service\Role;

final class GetOne extends BaseRoleService
{
    public function getOne(int $roleId)
    {
        if (self::isRedisEnabled() === true) {
            $role = $this->getOneFromCache($roleId);
        } else {
            $role = $this->getOneFromDb($roleId);
        }

        return $role;
    }

    public function getOneFromCache(int $roleId)
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
}
