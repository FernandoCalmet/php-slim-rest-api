<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\UserException;
use App\Repository\UserRepository;
use Firebase\JWT\JWT;

class UserService extends BaseService
{
    const REDIS_KEY = 'user:%s';

    protected $userRepository;

    protected $redisService;

    public function __construct(UserRepository $userRepository, RedisService $redisService)
    {
        $this->userRepository = $userRepository;
        $this->redisService = $redisService;
    }

    protected function getUserRepository(): UserRepository
    {
        return $this->userRepository;
    }

    protected function getUserFromDb(int $userId)
    {
        return $this->getUserRepository()->getUser($userId);
    }

    public function getAll(): array
    {
        return $this->getUserRepository()->getAll();
    }

    public function getOne(int $userId)
    {
        if (self::isRedisEnabled() === true) {
            $user = $this->getUserFromCache($userId);
        } else {
            $user = $this->getUserFromDb($userId);
        }
        return $user;
    }

    public function getUserFromCache(int $userId)
    {
        $redisKey = sprintf(self::REDIS_KEY, $userId);
        $key = $this->redisService->generateKey($redisKey);
        if ($this->redisService->exists($key)) {
            $data = $this->redisService->get($key);
            $user = json_decode(json_encode($data), false);
        } else {
            $user = $this->getUserFromDb($userId);
            $this->redisService->setex($key, $user);
        }
        return $user;
    }

    public function search(string $usersName): array
    {
        return $this->getUserRepository()->search($usersName);
    }

    public function saveInCache($id, $user)
    {
        $redisKey = sprintf(self::REDIS_KEY, $id);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->setex($key, $user);
    }

    public function deleteFromCache($userId)
    {
        $redisKey = sprintf(self::REDIS_KEY, $userId);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->del($key);
    }

    public function create(array $input)
    {
        $user = new \stdClass();
        $data = json_decode(json_encode($input), false);
        if (!isset($data->email)) {
            throw new UserException('The "Email" field is required.', 400);
        }
        if (!isset($data->password)) {
            throw new UserException('The "Password" field is required.', 400);
        }     
        if (!isset($data->first_name)) {
            throw new UserException('The "First Name" field is required.', 400);
        }   
        if (!isset($data->last_name)) {
            throw new UserException('The "Last Name" field is required.', 400);
        }       
        if (!isset($data->gender)) {
            throw new UserException('The "Gender" field is required.', 400);
        }       
        if (!isset($data->birthday)) {
            throw new UserException('The "Birthday" field is required.', 400);
        }
        $user->email = self::validateEmail($data->email);
        $user->password = hash('sha512', $data->password);
        $user->first_name = self::validateUserNames($data->first_name);
        $user->last_name = self::validateUserNames($data->last_name);
        $user->gender = self::validateUserGender($data->gender);
        $user->birthday = self::validateDate($data->birthday);
        $this->getUserRepository()->checkUserByEmail($user->email);
        $users = $this->getUserRepository()->create($user);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($users->id, $users);
        }
        return $users;
    }

    public function update(array $input, int $userId)
    {
        $user = $this->getUserFromDb($userId);
        $data = json_decode(json_encode($input), false);
        if (!isset($data->email) && !isset($data->password) && !isset($data->first_name) && !isset($data->last_name) && !isset($data->gender)) {
            throw new UserException('You must enter the user data to update.', 400);
        }
        if (isset($data->email)) {
            $user->email = self::validateEmail($data->email);
        }
        if (isset($data->password)) {
            $user->password = hash('sha512', $data->password);
        }     
        if (isset($data->first_name)) {
            $user->first_name = self::validateUserNames($data->first_name);
        }
        if (isset($data->last_name)) {
            $user->last_name = self::validateUserNames($data->last_name);
        }     
        if (isset($data->gender)) {
            $user->gender = self::validateUserGender($data->gender);
        }      
        $users = $this->getUserRepository()->update($user);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($users->id, $users);
        }
        return $users;
    }

    public function delete(int $userId): string
    {
        $this->getUserFromDb($userId);
        $this->getUserRepository()->deleteUserProfile($userId);
        $data = $this->getUserRepository()->delete($userId);
        if (self::isRedisEnabled() === true) {
            $this->deleteFromCache($userId);
        }
        return $data;
    }

    public function login(?array $input): string
    {
        $data = json_decode(json_encode($input), false);
        if (!isset($data->email)) {
            throw new UserException('The "Email" field is required.', 400);
        }
        if (!isset($data->password)) {
            throw new UserException('The "Password" field is required.', 400);
        }
        $password = hash('sha512', $data->password);
        $user = $this->getUserRepository()->loginUser($data->email, $password);
        $token = [
            'sub' => $user->id,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name, 
            'gender' => $user->gender,          
            'birthday' => $user->birthday,
            'role_id' => $user->role_id,
            'role_name' => $user->role_name,
            'iat' => time(),
            'exp' => time() + (7 * 24 * 60 * 60),
        ];
        return JWT::encode($token, getenv('SECRET_KEY'));
    }

    public function signup(array $input)
    {
        $user = new \stdClass();
        $data = json_decode(json_encode($input), false);
        if (!isset($data->email)) {
            throw new UserException('The "Email" field is required.', 400);
        }
        if (!isset($data->password)) {
            throw new UserException('The "Password" field is required.', 400);
        }     
        if (!isset($data->first_name)) {
            throw new UserException('The "First Name" field is required.', 400);
        }   
        if (!isset($data->last_name)) {
            throw new UserException('The "Last Name" field is required.', 400);
        }          
        if (!isset($data->gender)) {
            throw new UserException('The "Gender" field is required.', 400);
        }      
        if (!isset($data->birthday)) {
            throw new UserException('The "Birthday" field is required.', 400);
        }
        $user->email = self::validateEmail($data->email);
        $user->password = hash('sha512', $data->password);
        $user->first_name = self::validateUserNames($data->first_name);
        $user->last_name = self::validateUserNames($data->last_name); 
        $user->gender = self::validateUserGender($data->gender);
        $user->birthday = self::validateDate($data->birthday);
        $this->getUserRepository()->checkUserByEmail($user->email);
        $users = $this->getUserRepository()->signup($user);
        $this->getUserRepository()->createUserProfile($users->id);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($users->id, $users);
        }
        return $users;
    }
}
