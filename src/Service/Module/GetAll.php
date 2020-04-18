<?php

declare(strict_types=1);

namespace App\Service\Module;

class GetAll extends BaseModuleService
{
    public function getAll(): array
    {
        return $this->moduleRepository->getModules();
    }
}
