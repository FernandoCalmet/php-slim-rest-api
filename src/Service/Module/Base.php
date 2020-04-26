<?php

declare(strict_types=1);

namespace App\Service\Module;

use App\Exception\ModuleException;
use App\Repository\ModuleRepository;
use App\Service\BaseService;
use App\Service\RedisService;
use Respect\Validation\Validator as v;

abstract class Base extends BaseService
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

    protected static function validateModuleName(string $name): string
    {
        if (!v::length(2, 50)->validate($name)) {
            throw new ModuleException('The name of the module is invalid.', 400);
        }

        return $name;
    }

    protected static function validateDescription(string $description): string
    {
        if (!v::stringType()->length(2, 200)->validate($description)) {
            throw new ModuleException('Description no valid.', 400);
        }
        return $description;
    }    

    protected function getOneFromCache(int $moduleId)
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

    protected function getOneFromDb(int $moduleId)
    {
        return $this->moduleRepository->checkAndGetModule($moduleId);
    }

    protected function saveInCache($id, $module): void
    {
        $redisKey = sprintf(self::REDIS_KEY, $id);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->setex($key, $module);
    }

    protected function deleteFromCache($moduleId): void
    {
        $redisKey = sprintf(self::REDIS_KEY, $moduleId);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->del($key);
    }
}
