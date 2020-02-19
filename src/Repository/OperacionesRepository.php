<?php declare(strict_types=1);

namespace App\Repository;

use App\Exception\OperacionesException;

class OperacionesRepository extends BaseRepository
{
    public function __construct(\PDO $database)
    {
        $this->database = $database;
    }

    public function checkAndGetOperaciones(int $operacionesId)
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

    public function getAllOperaciones(): array
    {
        $query = 'SELECT * FROM `operaciones` ORDER BY `id`';
        $statement = $this->getDb()->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function createOperaciones($operaciones)
    {
        $query = 'INSERT INTO `operaciones` (`id`, `nombre`, `id_modulo`) VALUES (:id, :nombre, :id_modulo)';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $operaciones->id);
	$statement->bindParam('nombre', $operaciones->nombre);
	$statement->bindParam('id_modulo', $operaciones->id_modulo);
        $statement->execute();

        return $this->checkAndGetOperaciones((int) $this->getDb()->lastInsertId());
    }

    public function updateOperaciones($operaciones, $data)
    {
        if (isset($data->nombre)) { $operaciones->nombre = $data->nombre; }
        if (isset($data->id_modulo)) { $operaciones->id_modulo = $data->id_modulo; }

        $query = 'UPDATE `operaciones` SET `nombre` = :nombre, `id_modulo` = :id_modulo WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $operaciones->id);
	$statement->bindParam('nombre', $operaciones->nombre);
	$statement->bindParam('id_modulo', $operaciones->id_modulo);
        $statement->execute();

        return $this->checkAndGetOperaciones((int) $operaciones->id);
    }

    public function deleteOperaciones(int $operacionesId)
    {
        $query = 'DELETE FROM `operaciones` WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $operacionesId);
        $statement->execute();
    }
}
