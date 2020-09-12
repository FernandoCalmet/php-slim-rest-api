<?php

declare(strict_types=1);

namespace App\Controller\Task;

use App\Controller\BaseController;
use App\Exception\Task;
use App\Service\Task\Create;
use App\Service\Task\Delete;
use App\Service\Task\Find;
use App\Service\Task\Update;

abstract class Base extends BaseController
{
    protected function getServiceFindTask(): Find
    {
        return $this->container->get('find_task_service');
    }

    protected function getServiceCreateTask(): Create
    {
        return $this->container->get('create_task_service');
    }

    protected function getServiceUpdateTask(): Update
    {
        return $this->container->get('update_task_service');
    }

    protected function getServiceDeleteTask(): Delete
    {
        return $this->container->get('delete_task_service');
    }

    protected function getAndValidateUserId(array $input): int
    {
        if (isset($input['decoded']) && isset($input['decoded']->sub)) {
            return (int) $input['decoded']->sub;
        }

        throw new Task('Invalid task. Permission failed.', 400);
    }
}
