<?php

declare(strict_types=1);

namespace App\Service\Operation;

use App\Service\BaseService;
use App\Service\RedisService;
use App\Repository\OperationRepository;

abstract class BaseOperationService extends BaseService
{
    private const REDIS_KEY = 'operation:%s';

    /**
     * @var OperationRepository
     */
    protected $operationRepository;

    /**
     * @var RedisService
     */
    protected $redisService;

    public function __construct(OperationRepository $operationRepository, RedisService $redisService)
    {
        $this->operationRepository = $operationRepository;
        $this->redisService = $redisService;
    }

    public function getOneFromDb(int $operationId)
    {
        return $this->operationRepository->checkAndGetOperation($operationId);
    }

    public function saveInCache($id, $operation): void
    {
        $redisKey = sprintf(self::REDIS_KEY, $id);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->setex($key, $operation);
    }

    public function deleteFromCache($operationId): void
    {
        $redisKey = sprintf(self::REDIS_KEY, $operationId);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->del($key);
    }
}
