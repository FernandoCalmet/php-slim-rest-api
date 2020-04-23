<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exception\PermissionException;

final class PermissionRepository extends BaseRepository
{
    public function __construct(\PDO $database)
    {
        $this->database = $database;
    }

    public function checkAndGetPermission(int $permissionId): object
    {
        $query = 'SELECT * FROM `permissions` WHERE `id` = :id';
        $statement = $this->database->prepare($query);
        $statement->bindParam(':id', $permissionId);
        $statement->execute();
        $permission = $statement->fetchObject();
        if (empty($permission)) {
            throw new PermissionException('Permission not found.', 404);
        }

        return $permission;
    }

    public function getPermissions(): array
    {
        $query = 'SELECT * FROM `permissions` ORDER BY `id`';
        $statement = $this->database->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function searchPermissions($strPermissions): array
    {
        $query = 'SELECT * FROM `permissions` WHERE `role_id` LIKE :role_id OR `operation_id` LIKE :operation_id ORDER BY `id`';
        $role_id = '%' . $strPermissions . '%';
        $description = '%' . $strPermissions . '%';
        $statement = $this->database->prepare($query);
        $statement->bindParam('role_id', $role_id);
        $statement->bindParam('operation_id', $operation_id);
        $statement->execute();
        $permissions = $statement->fetchAll();
        if (!$permissions) {
            throw new PermissionException('No permissions with that role ID or operation ID were found.', 404);
        }

        return $permissions;
    }

    public function createPermission($data)
    {
        $query = 'INSERT INTO `permissions` (`role_id`, `operation_id`) VALUES (:role_id, :operation_id)';
        $statement = $this->database->prepare($query);
        $statement->bindParam(':role_id', $data->role_id);
        $statement->bindParam(':operation_id', $data->operation_id);
        $statement->execute();

        return $this->checkAndGetPermission((int) $this->database->lastInsertId());
    }

    public function updatePermission($permission): object
    {
        $query = 'UPDATE `permissions` SET `role_id` = :role_id, `operation_id` = :operation_id WHERE `id` = :id';
        $statement = $this->database->prepare($query);
        $statement->bindParam(':id', $permission->id);
        $statement->bindParam(':role_id', $permission->role_id);
        $statement->bindParam(':operation_id', $permission->operation_id);
        $statement->execute();

        return $this->checkAndGetPermission((int) $permission->id);
    }

    public function deletePermission(int $permissionId): void
    {
        $query = 'DELETE FROM `permissions` WHERE `id` = :id';
        $statement = $this->database->prepare($query);
        $statement->bindParam(':id', $permissionId);
        $statement->execute();
    }
}
