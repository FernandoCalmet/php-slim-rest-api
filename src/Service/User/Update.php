<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Exception\UserException;

final class Update extends Base
{
    public function update(array $input, int $userId): object
    {
        $user = $this->getUserFromDb($userId);
        $data = json_decode((string) json_encode($input), false);
        if (!isset($data->name) && !isset($data->email)) {
            throw new UserException('Enter the data to update the user.', 400);
        }
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
        /** @var \App\Entity\User $response */
        $response = $this->userRepository->updateUser($user);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($response->getId(), $response->getData());
        }
        if (self::isLoggerEnabled() === true) {
            $this->loggerService->setInfo('The user with the ID ' . $response->getId() . ' has updated successfully.');
        }

        return $response->getData();
    }
}
