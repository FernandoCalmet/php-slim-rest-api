<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exception\OperationException;

final class OperationRepository extends BaseRepository
{
    public function __construct(\PDO $database)
    {
        $this->database = $database;
    }

    public function checkAndGetOperation(int $operationId): object
    {
        $query = 'SELECT * FROM `operations` WHERE `id` = :id';
        $statement = $this->database->prepare($query);
        $statement->bindParam(':id', $operationId);
        $statement->execute();
        $operation = $statement->fetchObject();
        if (empty($operation)) {
            throw new OperationException('Operation not found.', 404);
        }

        return $operation;
    }

    public function getOperations(): array
    {
        $query = 'SELECT * FROM `operations` ORDER BY `id`';
        $statement = $this->database->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function searchOperations(string $strOperations): array
    {
        $query = 'SELECT * FROM `operations` WHERE `name` LIKE :name OR `description` LIKE :description ORDER BY `id`';
        $name = '%' . $strOperations . '%';
        $description = '%' . $strOperations . '%';
        $statement = $this->database->prepare($query);
        $statement->bindParam('name', $name);
        $statement->bindParam('description', $description);
        $statement->execute();
        $operations = $statement->fetchAll();
        if (!$operations) {
            throw new OperationException('No operations with that name or description were found.', 404);
        }

        return $operations;
    }

    public function createOperation($data)
    {
        $query = 'INSERT INTO `operations` (`name`, `description`) VALUES (:name, :description)';
        $statement = $this->database->prepare($query);
        $statement->bindParam(':name', $data->name);
        $statement->bindParam(':description', $data->description);
        $statement->execute();

        return $this->checkAndGetOperation((int) $this->database->lastInsertId());
    }

    public function updateOperation($operation): object
    {
        $query = '
            UPDATE `operations` 
            SET 
                `module_id` = :module_id, 
                `name` = :name, 
                `description` = :description 
            WHERE `id` = :id
        ';
        $statement = $this->database->prepare($query);
        $statement->bindParam(':id', $operation->id);
        $statement->bindParam(':module_id', $operation->module_id);
        $statement->bindParam(':name', $operation->name);
        $statement->bindParam(':description', $operation->description);
        $statement->execute();
        return $this->checkAndGetOperation((int) $operation->id);
    }

    public function deleteOperation(int $operationId): void
    {
        $query = 'DELETE FROM `operations` WHERE `id` = :id';
        $statement = $this->database->prepare($query);
        $statement->bindParam(':id', $operationId);
        $statement->execute();
    }
}
