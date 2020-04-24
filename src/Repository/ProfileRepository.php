<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exception\ProfileException;

final class ProfileRepository extends BaseRepository
{
    public function __construct(\PDO $database)
    {
        $this->database = $database;
    }

    public function checkAndGetProfile(int $profileId, int $userId): object
    {
        $query = 'SELECT * FROM `profiles` WHERE `id` = :id AND `user_id` = :userId';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $profileId);
        $statement->bindParam('userId', $userId);
        $statement->execute();
        $profile = $statement->fetchObject();
        if (empty($profile)) {
            throw new ProfileException('Profile not found.', 404);
        }

        return $profile;
    }

    public function getAllProfiles(): array
    {
        $query = 'SELECT * FROM `profiles` ORDER BY `id`';
        $statement = $this->getDb()->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function getAll(int $userId): array
    {
        $query = 'SELECT * FROM `profiles` WHERE `user_id` = :userId ORDER BY `id`';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('userId', $userId);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function search($profilesString, int $userId, $status): array
    {
        $query = $this->getSearchProfilesQuery($status);
        $username = '%' . $profilesString . '%';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('username', $username);
        $statement->bindParam('userId', $userId);
        if ($status === 'blocked' || $status === 'actived') {
            $statement->bindParam('status', $status);
        }
        $statement->execute();

        return $statement->fetchAll();
    }

    private function getSearchProfilesQuery($status)
    {
        $statusQuery = '';
        if ($status === 'blocked' || $status === 'actived') {
            $statusQuery = 'AND `status` = :status';
        }

        return "
            SELECT `id`, `username`, `biography`, `status` FROM `profiles`
            WHERE `username` LIKE :username AND `user_id` = :userId $statusQuery
            ORDER BY `id`
        ";
    }

    public function create($profile): object
    {
        $query = '
            INSERT INTO `profiles` (`username`, `biography`, `user_id`)
            VALUES (:username, :biography, :userId)
        ';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('userId', $profile->user_id);
        $statement->bindParam('username', $profile->username);
        $statement->bindParam('biography', $profile->biography);          
        $statement->execute();

        return $this->checkAndGetProfile((int) $this->database->lastInsertId(), (int) $profile->user_id);
    }

    public function update($profile): object
    {
        $query = '
            UPDATE `profiles`
            SET  `username` = :username, `biography` = :biography, `status` = :status
            WHERE `id` = :id AND `user_id` = :userId
        ';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $profile->id);
        $statement->bindParam('username', $profile->username);
        $statement->bindParam('biography', $profile->biography);
        $statement->bindParam('status', $profile->status);
        $statement->bindParam('userId', $profile->user_id);
        $statement->execute();

        return $this->checkAndGetProfile((int) $profile->id, (int) $profile->user_id);
    }

    public function delete(int $profileId, int $userId): string
    {
        $query = 'DELETE FROM `profiles` WHERE `id` = :id AND `user_id` = :userId';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $profileId);
        $statement->bindParam('userId', $userId);
        $statement->execute();
        return 'The profile was deleted.';
    }
}
