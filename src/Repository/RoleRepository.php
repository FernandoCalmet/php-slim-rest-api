<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exception\RoleException;

class RoleRepository extends BaseRepository
{
    public function __construct(\PDO $database)
    {
        $this->database = $database;
    }

    public function checkAndGetRole(int $roleId)
    {
        $query = 'SELECT * FROM `roles` WHERE `id` = :id';
        $statement = $this->database->prepare($query);
        $statement->bindParam(':id', $roleId);
        $statement->execute();
        $role = $statement->fetchObject();
        if (empty($role)) {
            throw new RoleException('Role not found.', 404);
        }

        return $role;
    }

    public function getRoles(): array
    {
        $query = 'SELECT * FROM `roles` ORDER BY `id`';
        $statement = $this->database->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function searchRoles(string $strRoles): array
    {
        $query = 'SELECT * FROM `roles` WHERE `name` LIKE :name OR `description` LIKE :description ORDER BY `id`';
        $name = '%' . $strRoles . '%';
        $description = '%' . $strRoles . '%';
        $statement = $this->database->prepare($query);
        $statement->bindParam('name', $name);
        $statement->bindParam('description', $description);
        $statement->execute();
        $roles = $statement->fetchAll();
        if (!$roles) {
            throw new RoleException('No roles with that name or description were found.', 404);
        }

        return $roles;
    }

    public function createRole($data)
    {
        $query = 'INSERT INTO `roles` (`name`, `description`) VALUES (:name, :description)';
        $statement = $this->database->prepare($query);
        $statement->bindParam(':name', $data->name);
        $statement->bindParam(':description', $data->description);
        $statement->execute();

        return $this->checkAndGetRole((int) $this->database->lastInsertId());
    }

    public function updateRole($role)
    {
        $query = 'UPDATE `roles` SET `name` = :name, `description` = :description WHERE `id` = :id';
        $statement = $this->database->prepare($query);
        $statement->bindParam(':id', $role->id);
        $statement->bindParam(':name', $role->name);
        $statement->bindParam(':description', $role->description);
        $statement->execute();

        return $this->checkAndGetRole((int) $role->id);
    }

    public function deleteRole(int $roleId)
    {
        $query = 'DELETE FROM `roles` WHERE `id` = :id';
        $statement = $this->database->prepare($query);
        $statement->bindParam(':id', $roleId);
        $statement->execute();
    }
}
