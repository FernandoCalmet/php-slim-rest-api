<?php

declare(strict_types=1);

namespace App\Service\Operation;

class GetOne extends BaseOperationService
{
    public function getOne(int $operationId)
    {
        if (self::isRedisEnabled() === true) {
            $operation = $this->getOneFromCache($operationId);
        } else {
            $operation = $this->getOneFromDb($operationId);
        }

        return $operation;
    }

    public function getOneFromCache(int $operationId)
    {
        $redisKey = sprintf(self::REDIS_KEY, $operationId);
        $key = $this->redisService->generateKey($redisKey);
        if ($this->redisService->exists($key)) {
            $operation = $this->redisService->get($key);
        } else {
            $operation = $this->getOneFromDb($operationId);
            $this->redisService->setex($key, $operation);
        }

        return $operation;
    }
}
