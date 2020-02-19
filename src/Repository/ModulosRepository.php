<?php declare(strict_types=1);

namespace App\Repository;

use App\Exception\ModulosException;

class ModulosRepository extends BaseRepository
{
    public function __construct(\PDO $database)
    {
        $this->database = $database;
    }

    public function checkAndGetModulos(int $modulosId)
    {
        $query = 'SELECT * FROM `modulos` WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $modulosId);
        $statement->execute();
        $modulos = $statement->fetchObject();
        if (empty($modulos)) {
            throw new ModulosException('Modulos not found.', 404);
        }

        return $modulos;
    }

    public function getAllModulos(): array
    {
        $query = 'SELECT * FROM `modulos` ORDER BY `id`';
        $statement = $this->getDb()->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function createModulos($modulos)
    {
        $query = 'INSERT INTO `modulos` (`id`, `nombre`) VALUES (:id, :nombre)';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $modulos->id);
	$statement->bindParam('nombre', $modulos->nombre);
        $statement->execute();

        return $this->checkAndGetModulos((int) $this->getDb()->lastInsertId());
    }

    public function updateModulos($modulos, $data)
    {
        if (isset($data->nombre)) { $modulos->nombre = $data->nombre; }

        $query = 'UPDATE `modulos` SET `nombre` = :nombre WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $modulos->id);
	$statement->bindParam('nombre', $modulos->nombre);
        $statement->execute();

        return $this->checkAndGetModulos((int) $modulos->id);
    }

    public function deleteModulos(int $modulosId)
    {
        $query = 'DELETE FROM `modulos` WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $modulosId);
        $statement->execute();
    }
}
