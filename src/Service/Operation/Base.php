<?php

declare(strict_types=1);

namespace App\Service\Operation;

use App\Exception\OperationException;
use App\Repository\OperationRepository;
use App\Service\BaseService;
use App\Service\RedisService;
use Respect\Validation\Validator as v;

abstract class Base extends BaseService
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

    protected static function validateOperationName(string $name): string
    {
        if (!v::length(2, 50)->validate($name)) {
            throw new OperationException('The name of the operation is invalid.', 400);
        }

        return $name;
    }

    protected static function validateDescription(string $description): string
    {
        if (!v::stringType()->length(2, 200)->validate($description)) {
            throw new OperationException('Description no valid.', 400);
        }
        return $description;
    }    

    protected function getOneFromCache(int $operationId)
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

    protected function getOneFromDb(int $operationId)
    {
        return $this->operationRepository->checkAndGetOperation($operationId);
    }

    protected function saveInCache($id, $operation): void
    {
        $redisKey = sprintf(self::REDIS_KEY, $id);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->setex($key, $operation);
    }

    protected function deleteFromCache($operationId): void
    {
        $redisKey = sprintf(self::REDIS_KEY, $operationId);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->del($key);
    }
}
