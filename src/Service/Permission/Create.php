<?php

declare(strict_types=1);

namespace App\Service\Permission;

use App\Exception\PermissionException;

class Create extends BasePermissionService
{
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
}
