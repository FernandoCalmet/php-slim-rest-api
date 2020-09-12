<?php

declare(strict_types=1);

namespace App\Service\Task;

use App\Exception\Task;

final class Create extends Base
{
    public function create(array $input): object
    {
        $data = json_decode((string) json_encode($input), false);
        if (!isset($data->name)) {
            throw new Task('The field "name" is required.', 400);
        }
        $mytask = new \App\Entity\Task();
        $mytask->updateName(self::validateTaskName($data->name));
        $desc = isset($data->description) ? $data->description : null;
        $mytask->updateDescription($desc);
        $status = 0;
        if (isset($data->status)) {
            $status = self::validateTaskStatus($data->status);
        }
        $mytask->updateStatus($status);
        $mytask->updateUserId((int) $data->decoded->sub);
        $mytask->updateCreatedAt(date('Y-m-d H:i:s'));
        /** @var \App\Entity\Task $task */
        $task = $this->taskRepository->create($mytask);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($task->getId(), $task->getUserId(), $task->getData());
        }

        return $task->getData();
    }
}
