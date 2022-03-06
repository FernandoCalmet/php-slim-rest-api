<?php

declare(strict_types=1);

namespace App\Service\Note;

use App\Entity\Note;

final class Create extends Base
{
    /**
     * @param array<string> $input
     */
    public function create(array $input): object
    {
        $data = json_decode((string) json_encode($input), false);
        if (!isset($data->name)) {
            throw new \App\Exception\NoteException('Invalid data: name is required.', 400);
        }
        $note = new Note();
        $note->updateName(self::validateNoteName($data->name));
        $desc = isset($data->description) ? $data->description : null;
        $note->updateDescription($desc);
        $note->updateCreatedAt(date('Y-m-d H:i:s'));
        /** @var Note $note */
        $response = $this->noteRepository->create($note);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($response->getId(), $response->toJson());
        }

        return $response->toJson();
    }
}
