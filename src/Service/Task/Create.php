<?php

declare(strict_types=1);

namespace App\Service\Task;

use App\Exception\TaskException;
use App\Entity\Task;

final class Create extends Base
{
    public function create(array $input): object
    {
        $data = json_decode((string) json_encode($input), false);
        if (!isset($data->name)) {
            throw new TaskException('The field "name" is required.', 400);
        }
        $task = new Task();
        $task->updateName(self::validateTaskName($data->name));
        $desc = isset($data->description) ? $data->description : null;
        $task->updateDescription($desc);
        $status = 0;
        if (isset($data->status)) {
            $status = self::validateTaskStatus($data->status);
        }
        $task->updateStatus($status);
        $task->updateUserId((int) $data->decoded->sub);
        $task->updateCreatedAt(date('Y-m-d H:i:s'));
        /** @var \App\Entity\Task $response */
        $response = $this->taskRepository->createTask($task);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($response->getId(), $response->getUserId(), $response->getData());
        }
        if (self::isLoggerEnabled() === true) {
            $this->loggerService->setInfo('The task with the ID ' . $response->getId() . ' has created successfully.');
        }

        return $response->getData();
    }
}
