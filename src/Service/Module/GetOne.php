<?php

declare(strict_types=1);

namespace App\Service\Module;

class GetOne extends BaseModuleService
{
    public function getOne(int $moduleId)
    {
        if (self::isRedisEnabled() === true) {
            $module = $this->getOneFromCache($moduleId);
        } else {
            $module = $this->getOneFromDb($moduleId);
        }

        return $module;
    }

    public function getOneFromCache(int $moduleId)
    {
        $redisKey = sprintf(self::REDIS_KEY, $moduleId);
        $key = $this->redisService->generateKey($redisKey);
        if ($this->redisService->exists($key)) {
            $module = $this->redisService->get($key);
        } else {
            $module = $this->getOneFromDb($moduleId);
            $this->redisService->setex($key, $module);
        }

        return $module;
    }
}
