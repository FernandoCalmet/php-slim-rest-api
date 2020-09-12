<?php

declare(strict_types=1);

namespace App\Service\User;

final class Update extends Base
{
    public function update(array $input, int $userId): object
    {
        $user = $this->getUserFromDb($userId);
        $data = json_decode((string) json_encode($input), false);
        if (isset($data->name)) {
            $user->updateName(self::validateUserName($data->name));
        }
        if (isset($data->email)) {
            $user->updateEmail(self::validateEmail($data->email));
        }
        if (isset($data->password)) {
            $user->updatePassword(hash('sha512', $data->password));
        }
        $user->updateUpdatedAt(date('Y-m-d H:i:s'));
        /** @var \App\Entity\User $users */
        $users = $this->userRepository->update($user);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($users->getId(), $users->getData());
        }

        return $users->getData();
    }
}
