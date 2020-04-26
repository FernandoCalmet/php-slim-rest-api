<?php

declare(strict_types=1);

namespace App\Service\Module;

use App\Exception\ModuleException;

final class ModuleService extends Base
{
    public function getAll(): array
    {
        return $this->moduleRepository->getModules();
    }

    public function getOne(int $moduleId)
    {
        if (self::isRedisEnabled() === true) {
            $module = $this->getOneFromCache($moduleId);
        } else {
            $module = $this->getOneFromDb($moduleId);
        }
        return $module;
    }

    public function search(string $modulesName): array
    {
        return $this->moduleRepository->searchModules($modulesName);
    }

    public function create($input)
    {
        $module = new \stdClass();
        $data = json_decode(json_encode($input), false);
        if (!isset($data->name)) {
            throw new ModuleException('Invalid data: name is required.', 400);
        }
        $module->name = self::validateModuleName($data->name);
        $module->description = null;
        if (isset($data->description)) {
            $module->description = self::validateDescription($data->description); 
        } 
        $modules = $this->moduleRepository->createModule($module);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($modules->id, $modules);
        }

        return $modules;
    }

    public function update($input, int $moduleId)
    {
        $module = $this->getOneFromDb($moduleId);
        $data = json_decode(json_encode($input), false);
        if (!isset($data->name) && !isset($data->description)) {
            throw new ModuleException('Enter the data to update the module.', 400);
        }
        if (isset($data->name)) {
            $module->name = self::validateModuleName($data->name);
        }
        if (isset($data->description)) {
            $module->description = self::validateDescription($data->description);
        }

        return $modules;
    }

    public function delete(int $moduleId): void
    {
        $this->getOneFromDb($moduleId);
        $this->moduleRepository->deleteModule($moduleId);
        if (self::isRedisEnabled() === true) {
            $this->deleteFromCache($moduleId);
        }
    }
}
