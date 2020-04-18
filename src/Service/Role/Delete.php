<?php

declare(strict_types=1);

namespace App\Service\Role;

class Delete extends BaseRoleService
{
    public function delete(int $roleId)
    {
        $this->getOneFromDb($roleId);
        $this->roleRepository->deleteRole($roleId);
        if (self::isRedisEnabled() === true) {
            $this->deleteFromCache($roleId);
        }
    }
}
