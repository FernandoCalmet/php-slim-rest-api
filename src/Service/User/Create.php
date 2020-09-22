<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Exception\UserException;

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
        $myuser = new \App\Entity\User();
        $myuser->updateName(self::validateUserName($data->name));
        $myuser->updateEmail(self::validateEmail($data->email));
        $myuser->updatePassword(hash('sha512', $data->password));
        $myuser->updateCreatedAt(date('Y-m-d H:i:s'));
        $this->userRepository->checkUserByEmail($data->email);
        /** @var \App\Entity\User $user */
        $user = $this->userRepository->createUser($myuser);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($user->getId(), $user->getData());
        }

        return $user->getData();
    }
}
