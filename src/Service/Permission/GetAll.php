<?php

declare(strict_types=1);

namespace App\Service\Permission;

final class GetAll extends BasePermissionService
{
    public function getAll(): array
    {
        return $this->permissionRepository->getPermissions();
    }
}
