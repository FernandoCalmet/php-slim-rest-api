<?php

declare(strict_types=1);

namespace App\Service\Task;

use App\Exception\TaskException;

final class Update extends Base
{
    public function update(array $input, int $taskId): object
    {
        $task = $this->getTaskFromDb($taskId, (int) $input['decoded']->sub);
        $data = json_decode((string) json_encode($input), false);
        if (!isset($data->name) && !isset($data->status)) {
            throw new TaskException('Enter the data to update the task.', 400);
        }
        if (isset($data->name)) {
            $task->updateName(self::validateTaskName($data->name));
        }
        if (isset($data->description)) {
            $task->updateDescription($data->description);
        }
        if (isset($data->status)) {
            $task->updateStatus(self::validateTaskStatus($data->status));
        }
        $task->updateUserId((int) $data->decoded->sub);
        $task->updateUpdatedAt(date('Y-m-d H:i:s'));
        /** @var \App\Entity\Task $tasks */
        $tasks = $this->taskRepository->updateTask($task);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($tasks->getId(), $tasks->getUserId(), $tasks->getData());
        }

        return $tasks->getData();
    }
}
