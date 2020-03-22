<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exception\PermisosException;

class PermisosRepository extends BaseRepository
{
    public function __construct(\PDO $database)
    {
        $this->database = $database;
    }

    public function checkAndGet(int $permisosId)
    {
        $query = 'SELECT * FROM `permisos` WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $permisosId);
        $statement->execute();
        $permisos = $statement->fetchObject();
        if (empty($permisos)) {
            throw new PermisosException('Permisos not found.', 404);
        }

        return $permisos;
    }

    public function getAll(): array
    {
        $query = 'SELECT * FROM `permisos` ORDER BY `id`';
        $statement = $this->getDb()->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function create($permisos)
    {
        $query = 'INSERT INTO `permisos` (`id`, `id_rol`, `id_operacion`) VALUES (:id, :id_rol, :id_operacion)';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $permisos->id);
        $statement->bindParam('id_rol', $permisos->id_rol);
        $statement->bindParam('id_operacion', $permisos->id_operacion);

        $statement->execute();

        return $this->checkAndGet((int) $this->getDb()->lastInsertId());
    }

    public function update($permisos, $data)
    {
        if (isset($data->id_rol)) { $permisos->id_rol = $data->id_rol; }
        if (isset($data->id_operacion)) { $permisos->id_operacion = $data->id_operacion; }


        $query = 'UPDATE `permisos` SET `id_rol` = :id_rol, `id_operacion` = :id_operacion WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $permisos->id);
        $statement->bindParam('id_rol', $permisos->id_rol);
        $statement->bindParam('id_operacion', $permisos->id_operacion);

        $statement->execute();

        return $this->checkAndGet((int) $permisos->id);
    }

    public function delete(int $permisosId)
    {
        $query = 'DELETE FROM `permisos` WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $permisosId);
        $statement->execute();
    }

    public function search(int $permisosId): array
    {
        $query = 'SELECT * FROM `permisos` WHERE `id` LIKE :id ORDER BY `id`';
        $id = '%' . $permisosId . '%';        
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $id);
        $statement->execute();
        $permisos = $statement->fetchAll();
        if (!$permisos) {
            throw new PermisosException('Not found.', 404);
        }

        return $permisos;
    }
}
