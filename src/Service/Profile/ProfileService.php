<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\ProfileException;

final class ProfileService extends Base
{ 
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

    public function search($profilesUsername, int $userId, $status): array
    {
        if ($status !== null) {
            $status = (string) $status;
        }
        return $this->getProfileRepository()->search($profilesUsername, $userId, $status);
    }

    public function create(array $input)
    {
        $profile = new \stdClass();
        $data = json_decode(json_encode($input), false);
        if (empty($data->username)) {
            throw new ProfileException('The "Username" field is required.', 400);
        }
        $profile->username = self::validateUsername($data->username);   
        $profile->biography = null;
        if (isset($data->biography)) {
            $profile->biography = self::validateBiography($data->biography);
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
        if (!isset($data->username) && !isset($data->status)) {
            throw new ProfileException('Enter the data to update the profile.', 400);
        }
        if (isset($data->username)) {
            $profile->username = self::validateUsername($data->username);
        }   
        if (isset($data->biography)) {
            $profile->biography = self::validateDescription($data->biography);
        }      
        if (isset($data->status)) {
            $profile->status = self::validateStatus($data->status);
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
