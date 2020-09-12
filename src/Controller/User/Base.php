<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Controller\BaseController;
use App\Exception\User;
use App\Service\User\Create;
use App\Service\User\Delete;
use App\Service\User\Find;
use App\Service\User\Update;
use App\Service\User\Login;

abstract class Base extends BaseController
{
    protected function getServiceFindUser(): Find
    {
        return $this->container->get('find_user_service');
    }

    protected function getServiceCreateUser(): Create
    {
        return $this->container->get('create_user_service');
    }

    protected function getServiceUpdateUser(): Update
    {
        return $this->container->get('update_user_service');
    }

    protected function getServiceDeleteUser(): Delete
    {
        return $this->container->get('delete_user_service');
    }

    protected function getServiceLoginUser(): Login
    {
        return $this->container->get('login_user_service');
    }

    protected function checkUserPermissions(int $userId, int $userIdLogged): void
    {
        if ($userId !== $userIdLogged) {
            throw new User('User permission failed.', 400);
        }
    }

    protected function getAndValidateUserId(array $input): int
    {
        if (isset($input['decoded']) && isset($input['decoded']->sub)) {
            return (int) $input['decoded']->sub;
        }

        throw new User('Invalid user. Permission failed.', 400);
    }
}
