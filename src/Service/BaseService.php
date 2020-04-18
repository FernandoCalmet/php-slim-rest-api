<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\ValidatorException;
use App\Exception\UserException;
use App\Exception\ProfileException;
use App\Exception\ModuleException;
use Respect\Validation\Validator as v;

abstract class BaseService
{
    protected static function isRedisEnabled(): bool
    {
        return filter_var(getenv('REDIS_ENABLED'), FILTER_VALIDATE_BOOLEAN);
    }

    protected static function validateUserNames(string $name): string
    {
        if (!v::alnum()->length(2, 100)->validate($name)) {
            throw new UserException('Name no valid.', 400);
        }
        return $name;
    }
   
    protected static function validateUserGender(string $gender): string
    {
        if (!v::stringType()->length(4, 6)->validate($gender)) {
            throw new UserException('Gender no valid.', 400);
        }
        return $gender;
    }   

    protected static function validateEmail(string $emailValue): string
    {
        $email = filter_var($emailValue, FILTER_SANITIZE_EMAIL);
        if (!v::email()->validate($email)) {
            throw new UserException('Email no valid.', 400);
        }
        return $email;
    }

    protected static function validateId(int $id): int
    {
        if (!v::length(1, 11)->validate($id)) {
            throw new ValidatorException('ID no valid', 400);
        }
        return $id;
    }    

    protected static function validateDate(string $date): string
    {
        if (!v::date()->validate($date)) {
            throw new ValidatorException('Date format not valid.', 400);
        }
        return $date;
    }

    protected static function validateDateTime(string $datetime): string
    {
        /*
        if (!v::dateTime()->validate($datetime)) {
            throw new ValidatorException('Date format not valid.', 400);
        }
        return $datetime;*/
        return $datetime;
    }

    protected static function validateTitle(string $title): string
    {
        if (!v::stringType()->length(2, 100)->validate($title)) {
            throw new ValidatorException('Name/Title no valid.', 400);
        }
        return $title;
    }

    protected static function validateDescription(string $description): string
    {
        if (!v::stringType()->length(2, 200)->validate($description)) {
            throw new ValidatorException('Description no valid.', 400);
        }
        return $description;
    }

    protected static function validateStatus(string $status): string
    {
        if (!v::stringType()->length(6, 9)->validate($status)) {
            throw new ValidatorException('Status no valid.', 400);
        }
        return $status;
    }

    protected static function validateImage(string $image): string
    {
        if (!v::image()->validate($image)) {
            throw new ValidatorException('Image no valid.', 400);
        }
        return $image;
    }
}
