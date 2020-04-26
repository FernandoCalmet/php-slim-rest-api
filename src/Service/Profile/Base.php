<?php

declare(strict_types=1);

namespace App\Service\Profile;

use App\Exception\ProfileException;
use App\Repository\ProfileRepository;
use App\Service\BaseService;
use App\Service\RedisService;
use Respect\Validation\Validator as v;

abstract class Base extends BaseService
{
    private const REDIS_KEY = 'profile:%s:user:%s';

    /**
     * @var ProfileRepository
     */
    protected $profileRepository;

    /**
     * @var RedisService
     */
    protected $redisService;

    public function __construct(ProfileRepository $profileRepository, RedisService $redisService)
    {
        $this->profileRepository = $profileRepository;
        $this->redisService = $redisService;
    }

    protected function getProfileRepository(): ProfileRepository
    {
        return $this->profileRepository;
    }

    protected static function validateUsername(string $username): string
    {
        if (!v::alnum()->length(2, 50)->validate($username)) {
            throw new ProfileException('Username no valid.', 400);
        }
        return $username;
    }
    
    protected static function validateBiography(string $biography): string
    {
        if (!v::stringType()->length(2, 200)->validate($biography)) {
            throw new ProfileException('Biography no valid.', 400);
        }
        return $biography;
    }

    protected static function validateStatus(string $status): string
    {
        if (!v::stringType()->length(6, 9)->validate($status)) {
            throw new ProfileException('Status no valid.', 400);
        }
        return $status;
    }

    protected function getProfileFromCache(int $profileId, int $userId)
    {
        $redisKey = sprintf(self::REDIS_KEY, $profileId, $userId);
        $key = $this->redisService->generateKey($redisKey);
        if ($this->redisService->exists($key)) {
            $profile = $this->redisService->get($key);
        } else {
            $profile = $this->getProfileFromDb($profileId, $userId);
            $this->redisService->setex($key, $profile);
        }

        return $profile;
    }

    protected function getProfileFromDb(int $profileId, int $userId)
    {
        return $this->getProfileRepository()->checkAndGetProfile($profileId, $userId);
    }

    protected function saveInCache($profileId, $userId, $profiles): void
    {
        $redisKey = sprintf(self::REDIS_KEY, $profileId, $userId);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->setex($key, $profiles);
    }

    protected function deleteFromCache($profileId, $userId): void
    {
        $redisKey = sprintf(self::REDIS_KEY, $profileId, $userId);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->del($key);
    }
}
