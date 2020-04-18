<?php

declare(strict_types=1);

namespace App\Service\Permission;

use App\Exception\PermissionException;

class Update extends BasePermissionService
{
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
        $permissions = $this->permissionRepository->updatePermission($permission);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($permissions->id, $permissions);
        }

        return $permissions;
    }
}
