<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exception\UserException;

class UserRepository extends BaseRepository
{
    public function __construct(\PDO $database)
    {
        $this->database = $database;
    }

    public function getUser(int $userId)
    {
        $query = '
            SELECT 
                users.id, 
                users.first_name, 
                users.last_name, 
                users.email, 
                users.role_id, 
                roles.name `role_name` 
            FROM users 
            INNER JOIN roles 
            ON users.role_id = roles.id 
            WHERE users.id = :id
        ';
        $statement = $this->database->prepare($query);
        $statement->bindParam('id', $userId);
        $statement->execute();
        $user = $statement->fetchObject();
        if (empty($user)) {
            throw new UserException('User not found.', 404);
        }
        return $user;
    }

    public function checkUserByEmail(string $email)
    {
        $query = 'SELECT * FROM `users` WHERE `email` = :email';
        $statement = $this->database->prepare($query);
        $statement->bindParam('email', $email);
        $statement->execute();
        $user = $statement->fetchObject();
        if (empty(!$user)) {
            throw new UserException('Email already exists.', 400);
        }
    }

    public function getAll(): array
    {
        $query = '
            SELECT `id`, `first_name`, `last_name`, `email` 
            FROM `users` ORDER BY `id`
        ';
        $statement = $this->database->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function search(string $usersNombres): array
    {
        $query = '
            SELECT `id`, `first_name`, `last_name`, `email` 
            FROM `users` 
            WHERE `first_name` LIKE :first_name OR `last_name` LIKE :last_name
            ORDER BY `id`
        ';
        $first_name = '%' . $usersNombres . '%';
        $statement = $this->database->prepare($query);
        $statement->bindParam('first_name', $first_name);
        $statement->bindParam('last_name', $first_name);
        $statement->execute();
        $users = $statement->fetchAll();
        if (!$users) {
            throw new UserException('User names not found.', 404);
        }
        return $users;
    }

    public function loginUser(string $email, string $password)
    {
        $query = '
            SELECT 
                users.id, 
                users.first_name, 
                users.last_name, 
                users.email, 
                users.gender, 
                users.birthday, 
                users.role_id, 
                roles.name `role_name` 
            FROM users 
            INNER JOIN roles 
            ON users.role_id = roles.id 
            WHERE users.email = :email AND users.password = :password
            ORDER BY users.id
        ';
        $statement = $this->database->prepare($query);
        $statement->bindParam('email', $email);
        $statement->bindParam('password', $password);
        $statement->execute();
        $user = $statement->fetchObject();
        if (empty($user)) {
            throw new UserException('Login failed: Email or password incorrect.', 400);
        }
        return $user;
    }      

    public function create($user)
    {
        $query = '
            INSERT INTO `users` (
                `email`, 
                `password`, 
                `first_name`, 
                `last_name`, 
                `gender`, 
                `birthday`
            ) 
            VALUES (
                :email, 
                :password, 
                :first_name, 
                :last_name, 
                :gender, 
                :birthday
            )
        ';
        $statement = $this->database->prepare($query);
        $statement->bindParam('email', $user->email);
        $statement->bindParam('password', $user->password);
        $statement->bindParam('first_name', $user->first_name);
        $statement->bindParam('last_name', $user->last_name);
        $statement->bindParam('gender', $user->gender); 
        $statement->bindParam('birthday', $user->birthday); 
        $statement->execute();
        return $this->getUser((int) $this->database->lastInsertId());
    }

    public function update($user)
    {
        $query = '
            UPDATE `users` 
            SET 
                `email` = :email,  
                `password` = :password,  
                `first_name` = :first_name, 
                `last_name` = :last_name, 
                `gender` = :gender
            WHERE `id` = :id
        ';
        $statement = $this->database->prepare($query);
        $statement->bindParam('id', $user->id);
        $statement->bindParam('email', $user->email);
        $statement->bindParam('password', $user->password);
        $statement->bindParam('first_name', $user->first_name);
        $statement->bindParam('last_name', $user->last_name);
        $statement->bindParam('gender', $user->gender);
        $statement->execute();
        return $this->getUser((int) $user->id);
    }

    public function delete(int $userId): string
    {
        $query = 'DELETE FROM `users` WHERE `id` = :id';
        $statement = $this->database->prepare($query);
        $statement->bindParam('id', $userId);
        $statement->execute();
        return 'User was successfully removed.';
    }

    public function deleteUserProfile(int $userId)
    {
        $query = 'DELETE FROM `profiles` WHERE `id` = :id';
        $statement = $this->database->prepare($query);
        $statement->bindParam('id', $userId);
        $statement->execute();
    }    

    public function signup($user)
    {
        $query = '
            INSERT INTO `users` (
                `email`, 
                `password`, 
                `first_name`, 
                `last_name`, 
                `gender`, 
                `birthday`
            ) 
            VALUES (
                :email, 
                :password, 
                :first_name, 
                :last_name, 
                :gender, 
                :birthday
            )
        ';
        $statement = $this->database->prepare($query);
        $statement->bindParam('email', $user->email);
        $statement->bindParam('password', $user->password);
        $statement->bindParam('first_name', $user->first_name);
        $statement->bindParam('last_name', $user->last_name);
        $statement->bindParam('gender', $user->gender);
        $statement->bindParam('birthday', $user->birthday); 
        $statement->execute();
        return $this->getUser((int) $this->database->lastInsertId());
    }

    public function createUserProfile(int $userId)
    {
        $query = '
            INSERT INTO `profiles` (`user_id`)
            VALUES (:userId)
        ';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('userId', $userId);
        $statement->execute();
    }
}
