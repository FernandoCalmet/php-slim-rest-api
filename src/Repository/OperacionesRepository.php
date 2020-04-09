<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exception\OperacionesException;

class OperacionesRepository extends BaseRepository
{
    public function __construct(\PDO $database)
    {
        $this->database = $database;
    }

    public function checkAndGet(int $operacionesId)
    {
        $query = 'SELECT * FROM `operaciones` WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $operacionesId);
        $statement->execute();
        $operaciones = $statement->fetchObject();
        if (empty($operaciones)) {
            throw new OperacionesException('No se a encontrado ninguna Operación con ese ID.', 404);
        }
        return $operaciones;
    }    

    public function getAllOperaciones(): array
    {
        $query = 'SELECT * FROM `operaciones` ORDER BY `id`';
        $statement = $this->getDb()->prepare($query);
        $statement->execute();
        $operaciones = $statement->fetchAll();
        if (empty($operaciones)) {
            throw new OperacionesException('No existe ningun registro de Operaciones.', 404);
        }
        return $operaciones;
    }

    public function getAll(): array
    {
        $query = 'SELECT `id`, `id_modulo`, `nombre`, `fecha_registro`, `fecha_modificacion` FROM `operaciones` ORDER BY `id`';
        $statement = $this->getDb()->prepare($query);
        $statement->execute();
        return  $statement->fetchAll();
    }

    public function getOperacion(int $operacionId)
    {
        $query = 'SELECT `id`, `id_modulo`, `nombre`, `fecha_registro`, `fecha_modificacion` FROM `usuarios` WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $operacionId);
        $statement->execute();
        $operacion = $statement->fetchObject();
        if (empty($operacion)) {
            throw new OperacionesException('No se a encontrado ningun registro de la Operación.', 404);
        }
        return $operacion;
    }

    public function create($operaciones)
    {
        $query = 'INSERT INTO `operaciones` (`id_modulo`, `nombre`) VALUES (:id_modulo, :nombre)';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id_modulo', $operaciones->id_modulo);        
        $statement->bindParam('nombre', $operaciones->nombre);
        $statement->execute();
        return $this->checkAndGet((int) $this->getDb()->lastInsertId());
    }

    public function update($operaciones)
    {   
        $query = 'UPDATE `operaciones` SET `id_modulo` = :id_modulo, `nombre` = :nombre WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $operaciones->id);
        $statement->bindParam('id_modulo', $operaciones->id_modulo);
        $statement->bindParam('nombre', $operaciones->nombre);
        $statement->execute();
        return $this->checkAndGet((int) $operaciones->id);
    }

    public function delete(int $operacionesId)
    {
        $query = 'DELETE FROM `operaciones` WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $operacionesId);
        $statement->execute();
        return 'La Operación fue eliminada exitosamente.';
    }

    public function search($operacionesNombre): array
    {
        $query = $this->getSearchQuery();
        $nombre = '%' . $operacionesNombre . '%';        
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('nombre', $nombre);
        $statement->execute();
        $operaciones = $statement->fetchAll();
        if (!$operaciones) {
            throw new OperacionesException('No se a encontrado ningun registro de Operaciones con esos Nombres.', 404);
        }
        return $operaciones;
    }

    private function getSearchQuery()
    {        
        return "
            SELECT * FROM `operaciones`
            WHERE `nombre` LIKE :nombre
            ORDER BY `id`
        ";
    }
}
