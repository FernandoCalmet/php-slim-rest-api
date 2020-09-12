<?php

declare(strict_types=1);

namespace App\Service\Task;

final class Delete extends Base
{
    public function delete(int $taskId, int $userId): void
    {
        $this->getTaskFromDb($taskId, $userId);
        $this->taskRepository->deleteTask($taskId, $userId);
        if (self::isRedisEnabled() === true) {
            $this->deleteFromCache($taskId, $userId);
        }
    }
}
