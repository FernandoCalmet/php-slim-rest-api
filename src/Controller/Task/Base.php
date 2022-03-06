<?php

declare(strict_types=1);

namespace App\Controller\Task;

use App\Controller\BaseController;
use App\Exception\TaskException;
use App\Service\Task\TaskService;

abstract class Base extends BaseController
{
    protected function getTaskService(): TaskService
    {
        return $this->container->get('task_service');
    }

    protected function getAndValidateUserId(array $input): int
    {
        if (isset($input['decoded']) && isset($input['decoded']->sub)) {
            return (int) $input['decoded']->sub;
        }

        throw new TaskException('Invalid task. Permission failed.', 400);
    }
}
