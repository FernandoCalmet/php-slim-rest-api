<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exception\ModulosException;

class ModulosRepository extends BaseRepository
{
    public function __construct(\PDO $database)
    {
        $this->database = $database;
    }

    public function checkAndGet(int $modulosId)
    {
        $query = 'SELECT * FROM `modulos` WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $modulosId);
        $statement->execute();
        $modulos = $statement->fetchObject();
        if (empty($modulos)) {
            throw new ModulosException('No se encontro el modulo', 404);
        }
        return $modulos;
    }    

    public function getAllModulos(): array
    {
        $query = 'SELECT * FROM `modulos` ORDER BY `id`';
        $statement = $this->getDb()->prepare($query);
        $statement->execute();
        $modulos = $statement->fetchAll();
        if (empty($modulos)) {
            throw new ModulosException('No existe ningun registro de Modulos.', 404);
        }
        return $modulos;
    }

    public function getAll(): array
    {
        $query = 'SELECT `id`, `nombre`, `fecha_registro`, `fecha_modificacion` FROM `modulos` ORDER BY `id`';
        $statement = $this->getDb()->prepare($query);
        $statement->execute();
        return  $statement->fetchAll();
    }

    public function getModulo(int $moduloId)
    {
        $query = 'SELECT `id`, `nombre`, `fecha_registro`, `fecha_modificacion` FROM `usuarios` WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $moduloId);
        $statement->execute();
        $modulo = $statement->fetchObject();
        if (empty($modulo)) {
            throw new ModulosException('No se a encontrado ningun registro del Modulo.', 404);
        }
        return $modulo;
    }

    public function create($modulos)
    {
        $query = 'INSERT INTO `modulos` (`id`, `nombre`) VALUES (:id, :nombre)';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $modulos->id);
	    $statement->bindParam('nombre', $modulos->nombre);
        $statement->execute();
        return $this->checkAndGet((int) $this->getDb()->lastInsertId());
    }

    public function update($modulos)
    {   
        $query = 'UPDATE `modulos` SET `nombre` = :nombre WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $modulos->id);
	    $statement->bindParam('nombre', $modulos->nombre);
        $statement->execute();
        return $this->checkAndGet((int) $modulos->id);
    }

    public function delete(int $modulosId)
    {
        $query = 'DELETE FROM `modulos` WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $modulosId);
        $statement->execute();
        return 'Se a eliminado el Modulo exitosamente.';
    }

    public function search($modulosNombre): array
    {
        $query = $this->getSearchQuery();
        $nombre = '%' . $modulosNombre . '%';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('nombre', $nombre);        
        $statement->execute();
        $modulos = $statement->fetchAll();
        if (!$modulos) {
            throw new ModulosException('No se a encontrado ningun registro de Modulos con esos Nombres.', 404);
        }
        return $modulos;
    }

    private function getSearchQuery()
    {        
        return "
            SELECT * FROM `modulos`
            WHERE `nombre` LIKE :nombre
            ORDER BY `id`
        ";
    }
}
