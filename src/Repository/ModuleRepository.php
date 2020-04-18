<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exception\ModuleException;

class ModuleRepository extends BaseRepository
{
    public function __construct(\PDO $database)
    {
        $this->database = $database;
    }

    public function checkAndGetModule(int $moduleId)
    {
        $query = 'SELECT * FROM `modules` WHERE `id` = :id';
        $statement = $this->database->prepare($query);
        $statement->bindParam(':id', $moduleId);
        $statement->execute();
        $module = $statement->fetchObject();
        if (empty($module)) {
            throw new ModuleException('Module not found.', 404);
        }

        return $module;
    }

    public function getModules(): array
    {
        $query = 'SELECT * FROM `modules` ORDER BY `id`';
        $statement = $this->database->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function searchModules(string $strModules): array
    {
        $query = 'SELECT * FROM `modules` WHERE `name` LIKE :name OR `description` LIKE :description ORDER BY `id`';
        $name = '%' . $strModules . '%';
        $description = '%' . $strModules . '%';
        $statement = $this->database->prepare($query);
        $statement->bindParam('name', $name);
        $statement->bindParam('description', $description);
        $statement->execute();
        $modules = $statement->fetchAll();
        if (!$modules) {
            throw new ModuleException('No modules with that name or description were found.', 404);
        }

        return $modules;
    }

    public function createModule($data)
    {
        $query = 'INSERT INTO `modules` (`name`, `description`) VALUES (:name, :description)';
        $statement = $this->database->prepare($query);
        $statement->bindParam(':name', $data->name);
        $statement->bindParam(':description', $data->description);
        $statement->execute();

        return $this->checkAndGetModule((int) $this->database->lastInsertId());
    }

    public function updateModule($module)
    {
        $query = '
            UPDATE `modules` SET `name` = :name, `description` = :description WHERE `id` = :id';
        $statement = $this->database->prepare($query);
        $statement->bindParam(':id', $module->id);
        $statement->bindParam(':name', $module->name);
        $statement->bindParam(':description', $module->description);
        $statement->execute();

        return $this->checkAndGetModule((int) $module->id);
    }

    public function deleteModule(int $moduleId)
    {
        $query = 'DELETE FROM `modules` WHERE `id` = :id';
        $statement = $this->database->prepare($query);
        $statement->bindParam(':id', $moduleId);
        $statement->execute();
    }
}
