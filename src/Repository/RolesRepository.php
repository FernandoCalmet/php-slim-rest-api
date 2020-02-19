<?php declare(strict_types=1);

namespace App\Repository;

use App\Exception\RolesException;

class RolesRepository extends BaseRepository
{
    public function __construct(\PDO $database)
    {
        $this->database = $database;
    }

    public function checkAndGetRoles(int $rolesId)
    {
        $query = 'SELECT * FROM `roles` WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $rolesId);
        $statement->execute();
        $roles = $statement->fetchObject();
        if (empty($roles)) {
            throw new RolesException('Roles not found.', 404);
        }

        return $roles;
    }

    public function getAllRoles(): array
    {
        $query = 'SELECT * FROM `roles` ORDER BY `id`';
        $statement = $this->getDb()->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function createRoles($roles)
    {
        $query = 'INSERT INTO `roles` (`id`, `nombre`) VALUES (:id, :nombre)';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $roles->id);
	$statement->bindParam('nombre', $roles->nombre);
        $statement->execute();

        return $this->checkAndGetRoles((int) $this->getDb()->lastInsertId());
    }

    public function updateRoles($roles, $data)
    {
        if (isset($data->nombre)) { $roles->nombre = $data->nombre; }

        $query = 'UPDATE `roles` SET `nombre` = :nombre WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $roles->id);
	$statement->bindParam('nombre', $roles->nombre);
        $statement->execute();

        return $this->checkAndGetRoles((int) $roles->id);
    }

    public function deleteRoles(int $rolesId)
    {
        $query = 'DELETE FROM `roles` WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $rolesId);
        $statement->execute();
    }
}
