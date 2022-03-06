<?php

declare(strict_types=1);

namespace App\Service\Note;

final class Delete extends Base
{
    public function delete(int $noteId): void
    {
        $this->getOneFromDb($noteId);
        $this->noteRepository->delete($noteId);
        if (self::isRedisEnabled() === true) {
            $this->deleteFromCache($noteId);
        }
        if (self::isLoggerEnabled() === true) {
            $this->loggerService->setInfo('The note with the ID ' . $noteId . ' has deleted successfully.');
        }
    }
}
