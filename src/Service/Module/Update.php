<?php

declare(strict_types=1);

namespace App\Service\Module;

use App\Exception\ModuleException;

class Update extends BaseModuleService
{
    public function update($input, int $moduleId)
    {
        $module = $this->getOneFromDb($moduleId);
        $data = json_decode(json_encode($input), false);
        if (!isset($data->name) && !isset($data->description)) {
            throw new ModuleException('Enter the data to update the module.', 400);
        }
        if (isset($data->name)) {
            $module->name = self::validateTitle($data->name);
        }
        if (isset($data->description)) {
            $module->description = self::validateDescription($data->description);
        }
        $modules = $this->moduleRepository->updateModule($module);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($modules->id, $modules);
        }

        return $modules;
    }
}
