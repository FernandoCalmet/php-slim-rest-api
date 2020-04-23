<?php

declare(strict_types=1);

namespace App\Service\Module;

use App\Exception\ModuleException;

final class Create extends BaseModuleService
{
    public function create($input)
    {
        $module = new \stdClass();
        $data = json_decode(json_encode($input), false);
        if (!isset($data->name)) {
            throw new ModuleException('Invalid data: name is required.', 400);
        }
        $module->name = self::validateTitle($data->name);
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
}
