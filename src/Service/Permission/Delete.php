<?php

declare(strict_types=1);

namespace App\Service\Permission;

class Delete extends BasePermissionService
{
    public function delete(int $permissionId)
    {
        $this->getOneFromDb($permissionId);
        $this->permissionRepository->deletePermission($permissionId);
        if (self::isRedisEnabled() === true) {
            $this->deleteFromCache($permissionId);
        }
    }
}
