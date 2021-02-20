<?php

declare(strict_types=1);

namespace App\Service\Note;

use App\Exception\NoteException;
use App\Entity\Note;

final class Create extends Base
{
    public function create(array $input): object
    {
        $data = json_decode((string) json_encode($input), false);
        if (!isset($data->name)) {
            throw new NoteException('Invalid data: name is required.', 400);
        }
        $note = new Note();
        $note->updateName(self::validateNoteName($data->name));
        $desc = isset($data->description) ? $data->description : null;
        $note->updateDescription($desc);
        $note->updateCreatedAt(date('Y-m-d H:i:s'));
        /** @var \App\Entity\Note $response */
        $response = $this->noteRepository->createNote($note);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($response->getId(), $response->toJson());
        }

        return $response->toJson();
    }
}
