<?php

declare(strict_types=1);

namespace App\Service\Role;

class GetAll extends BaseRoleService
{
    public function getAll(): array
    {
        return $this->roleRepository->getRoles();
    }
}
