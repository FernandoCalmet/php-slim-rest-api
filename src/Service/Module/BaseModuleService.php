<?php

declare(strict_types=1);

namespace App\Service\Module;

use App\Service\BaseService;
use App\Service\RedisService;
use App\Repository\ModuleRepository;

abstract class BaseModuleService extends BaseService
{
    private const REDIS_KEY = 'module:%s';

    /**
     * @var ModuleRepository
     */
    protected $moduleRepository;

    /**
     * @var RedisService
     */
    protected $redisService;

    public function __construct(ModuleRepository $moduleRepository, RedisService $redisService)
    {
        $this->moduleRepository = $moduleRepository;
        $this->redisService = $redisService;
    }

    public function getOneFromDb(int $moduleId)
    {
        return $this->moduleRepository->checkAndGetModule($moduleId);
    }

    public function saveInCache($id, $module): void
    {
        $redisKey = sprintf(self::REDIS_KEY, $id);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->setex($key, $module);
    }

    public function deleteFromCache($moduleId): void
    {
        $redisKey = sprintf(self::REDIS_KEY, $moduleId);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->del($key);
    }
}
