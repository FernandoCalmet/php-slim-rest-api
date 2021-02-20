<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Exception\UserException;
use App\Entity\User;

final class Create extends Base
{
    public function create(array $input): object
    {
        $data = json_decode((string) json_encode($input), false);
        if (!isset($data->name)) {
            throw new UserException('The field "name" is required.', 400);
        }
        if (!isset($data->email)) {
            throw new UserException('The field "email" is required.', 400);
        }
        if (!isset($data->password)) {
            throw new UserException('The field "password" is required.', 400);
        }
        $user = new User();
        $user->updateName(self::validateUserName($data->name));
        $user->updateEmail(self::validateEmail($data->email));
        $user->updatePassword(hash('sha512', $data->password));
        $user->updateCreatedAt(date('Y-m-d H:i:s'));
        $this->userRepository->checkUserByEmail($data->email);
        /** @var \App\Entity\User $response */
        $response = $this->userRepository->createUser($user);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($response->getId(), $response->toJson());
        }
        if (self::isLoggerEnabled() === true) {
            $this->loggerService->setInfo('The user with the ID ' . $response->getId() . ' has created successfully.');
        }

        return $response->toJson();
    }
}
