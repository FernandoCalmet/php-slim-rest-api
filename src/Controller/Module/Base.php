<?php

declare(strict_types=1);

namespace App\Controller\Module;

use App\Controller\BaseController;
use App\Service\Module\ModuleService;
use Slim\Container;

abstract class Base extends BaseController
{
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    protected function getModuleService(): ModuleService
    {
        return $this->container->get('module_service');
    }
}
