<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exception\Note;

final class NoteRepository extends BaseRepository
{
    public function checkAndGetNote(int $noteId): \App\Entity\Note
    {
        $query = 'SELECT * FROM `notes` WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $noteId);
        $statement->execute();
        $note = $statement->fetchObject(\App\Entity\Note::class);
        if (!$note) {
            throw new Note('Note not found.', 404);
        }

        return $note;
    }

    public function getNotes(): array
    {
        $query = 'SELECT * FROM `notes` ORDER BY `id`';
        $statement = $this->getDb()->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function getQueryNotesByPage(): string
    {
        return "
            SELECT *
            FROM `notes`
            WHERE `name` LIKE CONCAT('%', :name, '%')
            AND `description` LIKE CONCAT('%', :description, '%')
            ORDER BY `id`
        ";
    }

    public function getNotesByPage(
        int $page,
        int $perPage,
        ?string $name,
        ?string $description
    ): array {
        $params = [
            'name' => is_null($name) ? '' : $name,
            'description' => is_null($description) ? '' : $description,
        ];
        $query = $this->getQueryNotesByPage();
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('name', $params['name']);
        $statement->bindParam('description', $params['description']);
        $statement->execute();
        $total = $statement->rowCount();

        return $this->getResultsWithPagination(
            $query,
            $page,
            $perPage,
            $params,
            $total
        );
    }

    public function searchNotes(string $strNotes): array
    {
        $query = '
            SELECT *
            FROM `notes`
            WHERE `name` LIKE :name OR `description` LIKE :description
            ORDER BY `id`
        ';
        $name = '%' . $strNotes . '%';
        $description = '%' . $strNotes . '%';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('name', $name);
        $statement->bindParam('description', $description);
        $statement->execute();
        $notes = $statement->fetchAll();
        if (!$notes) {
            $message = 'No notes were found with that name or description.';
            throw new Note($message, 404);
        }

        return $notes;
    }

    public function createNote(\App\Entity\Note $note): \App\Entity\Note
    {
        $query = '
            INSERT INTO `notes`
                (`name`, `description`, `createdAt`)
            VALUES
                (:name, :description, :createdAt)
        ';
        $statement = $this->getDb()->prepare($query);
        $name = $note->getName();
        $desc = $note->getDescription();
        $created = $note->getCreatedAt();
        $statement->bindParam('name', $name);
        $statement->bindParam('description', $desc);
        $statement->bindParam('createdAt', $created);
        $statement->execute();

        return $this->checkAndGetNote((int) $this->getDb()->lastInsertId());
    }

    public function updateNote(\App\Entity\Note $note): \App\Entity\Note
    {
        $query = '
            UPDATE `notes`
            SET `name` = :name, `description` = :description, `updatedAt` = :updatedAt
            WHERE `id` = :id
        ';
        $statement = $this->getDb()->prepare($query);
        $id = $note->getId();
        $name = $note->getName();
        $desc = $note->getDescription();
        $updated = $note->getUpdatedAt();
        $statement->bindParam('id', $id);
        $statement->bindParam('name', $name);
        $statement->bindParam('description', $desc);
        $statement->bindParam('updatedAt', $updated);
        $statement->execute();

        return $this->checkAndGetNote((int) $id);
    }

    public function deleteNote(int $noteId): void
    {
        $query = 'DELETE FROM `notes` WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $noteId);
        $statement->execute();
    }
}
