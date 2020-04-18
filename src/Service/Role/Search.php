<?php

declare(strict_types=1);

namespace App\Service\Role;

class Search extends BaseRoleService
{
    public function search(string $rolesName): array
    {
        return $this->roleRepository->searchRoles($rolesName);
    }
}
