<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exception\RolesException;

class RolesRepository extends BaseRepository
{
    public function __construct(\PDO $database)
    {
        $this->database = $database;
    }

    public function checkAndGet(int $rolesId)
    {
        $query = 'SELECT * FROM `roles` WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $rolesId);
        $statement->execute();
        $roles = $statement->fetchObject();
        if (empty($roles)) {
            throw new RolesException('No se a encontrado ningun rol con ese ID.', 404);
        }
        return $roles;
    } 
      
    public function getAllRoles(): array
    {
        $query = 'SELECT * FROM `roles` ORDER BY `id`';
        $statement = $this->getDb()->prepare($query);
        $statement->execute();
        $roles = $statement->fetchAll();
        if (empty($roles)) {
            throw new RolesException('No existe ningun registro de roles.', 404);
        }
        return $roles;
    }

    public function getAll(): array
    {
        $query = 'SELECT `id`, `nombre`, `fecha_registro`, `fecha_modificacion` FROM `roles` ORDER BY `id`';
        $statement = $this->getDb()->prepare($query);
        $statement->execute();
        return  $statement->fetchAll();
    }

    public function getRol(int $rolId)
    {
        $query = 'SELECT `id`, `nombre`, `fecha_registro`, `fecha_modificacion` FROM `roles` WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $rolId);
        $statement->execute();
        $rol = $statement->fetchObject();
        if (empty($rol)) {
            throw new RolesException('No se a encontrado ningun registro del rol.', 404);
        }
        return $rol;
    } 

    public function create($roles)
    {
        $query = 'INSERT INTO `roles` (`nombre`) VALUES (:nombre)';
        $statement = $this->getDb()->prepare($query);   
	    $statement->bindParam('nombre', $roles->nombre);
        $statement->execute();
        return $this->checkAndGet((int) $this->getDb()->lastInsertId());
    }

    public function update($roles)
    {
        $query = 'UPDATE `roles` SET `nombre` = :nombre WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $roles->id);
	    $statement->bindParam('nombre', $roles->nombre);
        $statement->execute();
        return $this->checkAndGet((int) $roles->id);
    }

    public function delete(int $rolesId)
    {
        $query = 'DELETE FROM `roles` WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $rolesId);
        $statement->execute();
        return 'El Rol fue eliminado exitosamente.';
    }

    public function search($rolesNombre): array
    {
        $query = $this->getSearchQuery();
        $nombre = '%' . $rolesNombre . '%';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('nombre', $nombre);        
        $statement->execute();
        $roles = $statement->fetchAll();
        if (!$roles) {
            throw new RolesException('No se a encontrado ningun registro de Rol con ese Nombre.', 404);
        }
        return $roles;
    }

    private function getSearchQuery()
    {        
        return "
            SELECT * FROM `roles`
            WHERE `nombre` LIKE :nombre
            ORDER BY `id`
        ";
    }
}
