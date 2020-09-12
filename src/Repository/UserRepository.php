<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exception\User;

final class UserRepository extends BaseRepository
{
    public function checkAndGetUser(int $userId): \App\Entity\User
    {
        $query = 'SELECT `id`, `name`, `email` FROM `users` WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $userId);
        $statement->execute();
        $user = $statement->fetchObject(\App\Entity\User::class);
        if (!$user) {
            throw new User('User not found.', 404);
        }

        return $user;
    }

    public function checkUserByEmail(string $email): void
    {
        $query = 'SELECT * FROM `users` WHERE `email` = :email';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('email', $email);
        $statement->execute();
        $user = $statement->fetchObject();
        if ($user) {
            throw new User('Email already exists.', 400);
        }
    }

    public function getUsers(): array
    {
        $query = 'SELECT `id`, `name`, `email` FROM `users` ORDER BY `id`';
        $statement = $this->getDb()->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function getQueryUsersByPage(): string
    {
        return "
            SELECT `id`, `name`, `email`
            FROM `users`
            WHERE `name` LIKE CONCAT('%', :name, '%')
            AND `email` LIKE CONCAT('%', :email, '%')
            ORDER BY `id`
        ";
    }

    public function getUsersByPage(
        int $page,
        int $perPage,
        ?string $name,
        ?string $email
    ): array {
        $params = [
            'name' => is_null($name) ? '' : $name,
            'email' => is_null($email) ? '' : $email,
        ];
        $query = $this->getQueryUsersByPage();
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('name', $params['name']);
        $statement->bindParam('email', $params['email']);
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

    public function searchUsers(string $usersName): array
    {
        $query = '
            SELECT `id`, `name`, `email`
            FROM `users`
            WHERE `name` LIKE :name
            ORDER BY `id`
        ';
        $name = '%' . $usersName . '%';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('name', $name);
        $statement->execute();
        $users = $statement->fetchAll();
        if (!$users) {
            throw new User('User name not found.', 404);
        }

        return $users;
    }

    public function createUser(\App\Entity\User $user): \App\Entity\User
    {
        $query = '
            INSERT INTO `users`
                (`name`, `email`, `password`, `createdAt`)
            VALUES
                (:name, :email, :password, :createdAt)
        ';
        $statement = $this->getDb()->prepare($query);
        $name = $user->getName();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $created = $user->getCreatedAt();
        $statement->bindParam('name', $name);
        $statement->bindParam('email', $email);
        $statement->bindParam('password', $password);
        $statement->bindParam('createdAt', $created);
        $statement->execute();

        return $this->checkAndGetUser((int) $this->getDb()->lastInsertId());
    }

    public function updateUser(\App\Entity\User $user): \App\Entity\User
    {
        $query = '
            UPDATE `users` 
            SET 
                `name` = :name, 
                `email` = :email, 
                `password` = :password, 
                `updatedAt` = :updatedAt 
            WHERE `id` = :id
        ';
        $statement = $this->getDb()->prepare($query);
        $id = $user->getId();
        $name = $user->getName();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $updated = $user->getUpdatedAt();
        $statement->bindParam('id', $id);
        $statement->bindParam('name', $name);
        $statement->bindParam('email', $email);
        $statement->bindParam('password', $password);
        $statement->bindParam('updatedAt', $updated);
        $statement->execute();

        return $this->checkAndGetUser((int) $id);
    }

    public function deleteUser(int $userId): void
    {
        $query = 'DELETE FROM `users` WHERE `id` = :id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $userId);
        $statement->execute();
    }

    public function deleteUserTasks(int $userId): void
    {
        $query = 'DELETE FROM `tasks` WHERE `userId` = :userId';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('userId', $userId);
        $statement->execute();
    }

    public function loginUser(string $email, string $password): \App\Entity\User
    {
        $query = '
            SELECT *
            FROM `users`
            WHERE `email` = :email AND `password` = :password
            ORDER BY `id`
        ';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('email', $email);
        $statement->bindParam('password', $password);
        $statement->execute();
        $user = $statement->fetchObject(\App\Entity\User::class);
        if (!$user) {
            throw new User('Login failed: Email or password incorrect.', 400);
        }

        return $user;
    }
}
