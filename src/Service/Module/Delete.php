<?php

declare(strict_types=1);

namespace App\Service\Module;

class Delete extends BaseModuleService
{
    public function delete(int $moduleId)
    {
        $this->getOneFromDb($moduleId);
        $this->moduleRepository->deleteModule($moduleId);
        if (self::isRedisEnabled() === true) {
            $this->deleteFromCache($moduleId);
        }
    }
}
