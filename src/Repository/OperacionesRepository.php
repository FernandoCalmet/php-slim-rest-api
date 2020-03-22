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
            throw new OperacionesException('Operaciones not found.', 404);
        }

        return $operaciones;
    }

    public function getAll(): array
    {
        $query = 'SELECT * FROM `operaciones` ORDER BY `id`';
        $statement = $this->getDb()->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function create($operaciones)
    {
        $query = 'INSERT INTO `operaciones` (`id`, `id_modulo`, `nombre`) VALUES (:id, :id_modulo, :nombre)';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $operaciones->id);
        $statement->bindParam('id_modulo', $operaciones->id_modulo);
        $statement->bindParam('nombre', $operaciones->nombre);

        $statement->execute();

        return $this->checkAndGet((int) $this->getDb()->lastInsertId());
    }

    public function update($operaciones, $data)
    {
        if (isset($data->id_modulo)) { $operaciones->id_modulo = $data->id_modulo; }
        if (isset($data->nombre)) { $operaciones->nombre = $data->nombre; }


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
    }

    public function search(string $operacionesName): array
    {
        $query = 'SELECT * FROM `operaciones` WHERE `nombre` LIKE :name ORDER BY `id`';
        $name = '%' . $operacionesName . '%';        
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('name', $name);
        $statement->execute();
        $operaciones = $statement->fetchAll();
        if (!$operaciones) {
            throw new OperacionesException('Not found.', 404);
        }

        return $operaciones;
    }
}
