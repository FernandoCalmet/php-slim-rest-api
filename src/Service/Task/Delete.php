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
        if (self::isLoggerEnabled() === true) {
            $this->loggerService->setInfo('The task with the ID ' . $taskId . ' from the User with the Id ' . $userId . ' has deleted successfully.');
        }
    }
}
