<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\ProfileException;
use App\Repository\ProfileRepository;

final class ProfileService extends BaseService
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

    protected function getProfileFromDb(int $profileId, int $userId)
    {
        return $this->getProfileRepository()->checkAndGetProfile($profileId, $userId);
    }

    public function getAllProfiles(): array
    {
        return $this->getProfileRepository()->getAllProfiles();
    }

    public function getAll(int $userId): array
    {
        return $this->getProfileRepository()->getAll($userId);
    }

    public function getOne(int $profileId, int $userId)
    {
        if (self::isRedisEnabled() === true) {
            $profile = $this->getProfileFromCache($profileId, $userId);
        } else {
            $profile = $this->getProfileFromDb($profileId, $userId);
        }
        return $profile;
    }

    public function getProfileFromCache(int $profileId, int $userId)
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

    public function search($profilesName, int $userId, $status): array
    {
        if ($status !== null) {
            $status = (int) $status;
        }
        return $this->getProfileRepository()->search($profilesName, $userId, $status);
    }

    public function saveInCache($profileId, $userId, $profiles): void
    {
        $redisKey = sprintf(self::REDIS_KEY, $profileId, $userId);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->setex($key, $profiles);
    }

    public function deleteFromCache($profileId, $userId): void
    {
        $redisKey = sprintf(self::REDIS_KEY, $profileId, $userId);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->del($key);
    }

    public function create(array $input)
    {
        $profile = new \stdClass();
        $data = json_decode(json_encode($input), false);
        if (empty($data->biography)) {
            throw new ProfileException('The "Biography" field is required.', 400);
        }
        $profile->biography = self::validateDescription($data->biography);       
        $profile->status = 0;
        if (isset($data->status)) {
            $profile->status = self::validateProfileStatus($data->status);
        }
        $profile->userId = $data->decoded->sub;
        $profiles = $this->getProfileRepository()->create($profile);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($profiles->id, $profile->userId, $profiles);
        }
        return $profiles;
    }

    public function update(array $input, int $profileId)
    {
        $profile = $this->getProfileFromDb($profileId, (int) $input['decoded']->sub);
        $data = json_decode(json_encode($input), false);
        if (!isset($data->biography) && !isset($data->status)) {
            throw new ProfileException('Enter the data to update the profile.', 400);
        }
        if (isset($data->biography)) {
            $profile->biography = self::validateDescription($data->biography);
        }      
        if (isset($data->status)) {
            $profile->status = self::validateProfileStatus($data->status);
        }
        $profile->userId = $data->decoded->sub;
        $profiles = $this->getProfileRepository()->update($profile);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($profiles->id, $profile->userId, $profiles);
        }
        return $profiles;
    }

    public function delete(int $profileId, int $userId): string
    {
        $this->getProfileFromDb($profileId, $userId);
        $data = $this->getProfileRepository()->delete($profileId, $userId);
        if (self::isRedisEnabled() === true) {
            $this->deleteFromCache($profileId, $userId);
        }
        return $data;
    }
}
