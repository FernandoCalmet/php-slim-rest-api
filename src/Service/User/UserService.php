<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Exception\UserException;
use Firebase\JWT\JWT;

final class UserService extends Base
{  
    public function getAll(): array
    {
        return $this->userRepository->getAll();
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

    public function search(string $usersName): array
    {
        return $this->userRepository->search($usersName);
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
        $user->first_name = self::validateFirstName($data->first_name);
        $user->last_name = self::validateLastName($data->last_name);
        $user->gender = self::validateGender($data->gender);
        $user->birthday = self::validateBirthday($data->birthday);
        $this->userRepository->checkUserByEmail($user->email);
        $users = $this->userRepository->create($user);
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
            $user->first_name = self::validateFirstName($data->first_name);
        }
        if (isset($data->last_name)) {
            $user->last_name = self::validateLastName($data->last_name);
        }     
        if (isset($data->gender)) {
            $user->gender = self::validateGender($data->gender);
        }      
        $users = $this->userRepository->update($user);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($users->id, $users);
        }
        return $users;
    }

    public function delete(int $userId): string
    {
        $this->getUserFromDb($userId);
        $this->userRepository->deleteUserProfile($userId);
        $data = $this->userRepository->delete($userId);
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
        $user = $this->userRepository->loginUser($data->email, $password);
        $token = [
            'sub' => $user->id,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name, 
            'gender' => $user->gender,          
            'birthday' => $user->birthday,
            'role_id' => $user->role_id,
            'role_name' => $user->role_name,
            'profile_id' => $user->profile_id,
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
        $user->first_name = self::validateFirstName($data->first_name);
        $user->last_name = self::validateLastName($data->last_name); 
        $user->gender = self::validateGender($data->gender);
        $user->birthday = self::validateBirthday($data->birthday);
        $this->userRepository->checkUserByEmail($user->email);
        $users = $this->userRepository->signup($user);
        $this->userRepository->createUserProfile($users->id, $users->first_name, $users->last_name);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($users->id, $users);
        }
        return $users;
    }
}
