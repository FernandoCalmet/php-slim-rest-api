<?php

declare(strict_types=1);

namespace App\Service\Role;

use App\Exception\RoleException;

final class Update extends BaseRoleService
{
    public function update($input, int $roleId)
    {
        $role = $this->getOneFromDb($roleId);
        $data = json_decode(json_encode($input), false);
        if (!isset($data->name) && !isset($data->description)) {
            throw new RoleException('Enter the data to update the role.', 400);
        }
        if (isset($data->name)) {
            $role->name = self::validateTitle($data->name);
        }
        if (isset($data->description)) {
            $role->description = self::validateDescription($data->description);
        }
        $roles = $this->roleRepository->updateRole($role);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($roles->id, $roles);
        }

        return $roles;
    }
}
