<?php

declare(strict_types=1);

namespace App\Service\Permission;

use App\Exception\PermissionException;

final class PermissionService extends Base
{
    public function getAll(): array
    {
        return $this->permissionRepository->getPermissions();
    }

    public function getOne(int $permissionId)
    {
        if (self::isRedisEnabled() === true) {
            $permission = $this->getOneFromCache($permissionId);
        } else {
            $permission = $this->getOneFromDb($permissionId);
        }
        return $permission;
    }

    public function search(int $permissionsId): array
    {
        return $this->permissionRepository->searchPermissions($permissionsId);
    }

    public function create($input)
    {
        $permission = new \stdClass();
        $data = json_decode(json_encode($input), false);
        if (!isset($data->role_id)) {
            throw new PermissionException('Invalid data: Role is required.', 400);
        }
        $permission->role_id = self::validateId($data->role_id);
        if (!isset($data->operation_id)) {
            throw new PermissionException('Invalid data: Operation is required.', 400);
        }
        $permission->operation_id = self::validateId($data->operation_id);
        $permissions = $this->permissionRepository->createPermission($permission);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($permissions->id, $permissions);
        }

        return $permissions;
    }

    public function update($input, int $permissionId)
    {
        $permission = $this->getOneFromDb($permissionId);
        $data = json_decode(json_encode($input), false);
        if (!isset($data->role_id) && !isset($data->operation_id)) {
            throw new PermissionException('Enter the data to update the permission.', 400);
        }
        if (isset($data->role_id)) {
            $permission->role_id = self::validateId($data->role_id);
        }      
        if (isset($data->operation_id)) {
            $permission->operation_id = self::validateId($data->operation_id);
        }

        return $permissions;
    }

    public function delete(int $permissionId): void
    {
        $this->getOneFromDb($permissionId);
        $this->permissionRepository->deletePermission($permissionId);
        if (self::isRedisEnabled() === true) {
            $this->deleteFromCache($permissionId);
        }
    }
}
