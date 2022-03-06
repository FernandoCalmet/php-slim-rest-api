<?php

declare(strict_types=1);

namespace App\Service\Note;

final class Update extends Base
{
    /**
     * @param array<string> $input
     */
    public function update(array $input, int $noteId): object
    {
        $note = $this->getOneFromDb($noteId);
        $data = json_decode((string) json_encode($input), false);
        if (isset($data->name)) {
            $note->updateName(self::validateNoteName($data->name));
        }
        if (isset($data->description)) {
            $note->updateDescription($data->description);
        }
        $note->updateUpdatedAt(date('Y-m-d H:i:s'));
        /** @var Note $notes */
        $response = $this->noteRepository->update($note);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($response->getId(), $response->toJson());
        }
        if (self::isLoggerEnabled() === true) {
            $this->loggerService->setInfo('The note with the ID ' . $response->getId() . ' has updated successfully.');
        }

        return $response->toJson();
    }
}
