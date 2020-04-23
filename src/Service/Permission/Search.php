<?php

declare(strict_types=1);

namespace App\Service\Permission;

final class Search extends BasePermissionService
{
    public function search($permissionsName): array
    {
        return $this->permissionRepository->searchPermissions($permissionsName);
    }
}
