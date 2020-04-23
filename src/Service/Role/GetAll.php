<?php

declare(strict_types=1);

namespace App\Service\Role;

final class GetAll extends BaseRoleService
{
    public function getAll(): array
    {
        return $this->roleRepository->getRoles();
    }
}
