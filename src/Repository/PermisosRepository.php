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
            throw new PermisosException('No se a encontrado ningun Permiso con ese ID.', 404);
        }
        return $permisos;
    }    

    public function getAllPermisos(): array
    {
        $query = 'SELECT * FROM `permisos` ORDER BY `id`';
        $statement = $this->getDb()->prepare($query);
        $statement->execute();
        $permisos = $statement->fetchAll();
        if (empty($permisos)) {
            throw new PermisosException('No existe ningun registro de Permisos.', 404);
        }
        return $permisos;
    } 
 
    public function getAll(): array
    {
        $query = 'SELECT `id`, `id_rol`, `id_operacion`, `fecha_registro`, `fecha_modificacion` FROM `permisos` ORDER BY `id`';
        $statement = $this->getDb()->prepare($query);
        $statement->execute();
        return  $statement->fetchAll();
    }

    public function getPermiso(int $permisoId)
    {
        $query = 'SELECT `id`, `id_rol`, `id_operacion`, `fecha_registro`, `fecha_modificacion` FROM `usuarios` WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $permisoId);
        $statement->execute();
        $permiso = $statement->fetchObject();
        if (empty($permiso)) {
            throw new PermisosException('No se a encontrado ningun registro del Permiso.', 404);
        }
        return $permiso;
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

    public function update($permisos)
    {   
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
        return 'El Permiso fue eliminado exitosamente.';
    }

    public function search($permisosId): array
    {
        $query = $this->getSearchQuery();
        $id = '%' . $permisosId . '%';        
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $id);
        $statement->execute();        
        $permisos = $statement->fetchAll();        
        if (!$permisos) {
            throw new PermisosException('No se a encontrado ningun registro de Permisos con esos ID.', 404);
        }
        return $permisos;
    }

    private function getSearchQuery()
    {        
        return "
            SELECT * FROM `permisos`
            WHERE `id` LIKE :id
            ORDER BY `id`
        ";
    }
}
