<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\ValidatorException;
use Respect\Validation\Validator as v;

abstract class BaseService
{
    protected static function isRedisEnabled(): bool
    {
        return filter_var(getenv('REDIS_ENABLED'), FILTER_VALIDATE_BOOLEAN);
    }          

    protected static function validateId(int $id): int
    {
        if (!v::length(1, 11)->validate($id)) {
            throw new ValidatorException('ID no valid', 400);
        }
        return $id;
    }    

    protected static function validateImage(string $image): string
    {
        if (!v::image()->validate($image)) {
            throw new ValidatorException('Image no valid.', 400);
        }
        return $image;
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
}
