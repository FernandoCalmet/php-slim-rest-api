<?php

declare(strict_types=1);

namespace App\Service\Role;

use App\Exception\RoleException;

final class Create extends BaseRoleService
{
    public function create($input)
    {
        $role = new \stdClass();
        $data = json_decode(json_encode($input), false);
        if (!isset($data->name)) {
            throw new RoleException('Invalid data: name is required.', 400);
        }
        $role->name = self::validateTitle($data->name);
        $role->description = null;
        if (isset($data->description)) {
            $role->description = self::validateDescription($data->description); 
        }        
        $roles = $this->roleRepository->createRole($role);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($roles->id, $roles);
        }

        return $roles;
    }
}
