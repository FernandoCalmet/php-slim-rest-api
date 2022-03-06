<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\User;

final class Create extends Base
{
    public function create(array $input): object
    {
        $data = $this->validateUserData($input);
        /** @var User $user */
        $user = $this->userRepository->create($data);

        if (self::isRedisEnabled() === true) {
            $this->saveInCache($user->getId(), $user->toJson());
        }
        if (self::isLoggerEnabled() === true) {
            $this->loggerService->setInfo('The user with the ID ' . $user->getId() . ' has created successfully.');
        }

        return $user->toJson();
    }

    /**
     * @param array<string> $input
     */
    private function validateUserData(array $input): User
    {
        $data = json_decode((string) json_encode($input), false);
        if (!isset($data->name)) {
            throw new \App\Exception\UserException('The field "name" is required.', 400);
        }
        if (!isset($data->email)) {
            throw new \App\Exception\UserException('The field "email" is required.', 400);
        }
        if (!isset($data->password)) {
            throw new \App\Exception\UserException('The field "password" is required.', 400);
        }
        $user = new User();
        $user->updateName(self::validateUserName($data->name));
        $user->updateEmail(self::validateEmail($data->email));
        $user->updatePassword(hash('sha512', $data->password));
        $user->updateCreatedAt(date('Y-m-d H:i:s'));
        $this->userRepository->checkUserByEmail($data->email);

        return $user;
    }
}
