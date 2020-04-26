<?php

declare(strict_types=1);

namespace App\Service\Role;

use App\Exception\RoleException;

final class RoleService extends Base
{
    public function getAll(): array
    {
        return $this->roleRepository->getRoles();
    }

    public function getOne(int $roleId)
    {
        if (self::isRedisEnabled() === true) {
            $role = $this->getOneFromCache($roleId);
        } else {
            $role = $this->getOneFromDb($roleId);
        }
        return $role;
    }

    public function search(string $rolesName): array
    {
        return $this->roleRepository->searchRoles($rolesName);
    }

    public function create($input)
    {
        $role = new \stdClass();
        $data = json_decode(json_encode($input), false);
        if (!isset($data->name)) {
            throw new RoleException('Invalid data: name is required.', 400);
        }
        $role->name = self::validateRoleName($data->name);
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

    public function update($input, int $roleId)
    {
        $role = $this->getOneFromDb($roleId);
        $data = json_decode(json_encode($input), false);
        if (!isset($data->name) && !isset($data->description)) {
            throw new RoleException('Enter the data to update the role.', 400);
        }
        if (isset($data->name)) {
            $role->name = self::validateRoleName($data->name);
        }
        if (isset($data->description)) {
            $role->description = self::validateDescription($data->description);
        }

        return $roles;
    }

    public function delete(int $roleId): void
    {
        $this->getOneFromDb($roleId);
        $this->roleRepository->deleteRole($roleId);
        if (self::isRedisEnabled() === true) {
            $this->deleteFromCache($roleId);
        }
    }
}
