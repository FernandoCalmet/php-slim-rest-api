<?php declare(strict_types=1);

namespace App\Service;

use App\Exception\ValidatorException;
use App\Exception\UsuariosException;
use App\Exception\RolesException;
use App\Exception\PermisosException;
use App\Exception\OperacionesException;
use App\Exception\ModulosException;
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
            throw new ValidatorException('ID no es valido', 400);
        }
        return $id;
    }

    protected static function validateEmail(string $correo): string
    {
        $email = filter_var($correo, FILTER_SANITIZE_EMAIL);
        if (!v::email()->validate($email)) {
            throw new ValidatorException('Correo no es valido.', 400);
        }
        return $email;
    }

    protected static function validateNombre(string $nombre): string
    {
        if (!v::stringType()->length(2, 200)->validate($nombre)) {
            throw new ValidatorException('Nombre no es valido.', 400);
        }
        return $nombre;
    }

    protected static function validateDate(string $date): string
    {
        if (!v::date()->validate($date)) {
            throw new ValidatorException('Formato de Fecha no es valida', 400);
        }
        return $date;
    }

    protected static function validateDateTime(string $datetime): string
    {
        /*
        if (!v::dateTime()->validate($datetime)) {
            throw new ValidatorException('Formato de Fecha no es valida', 400);
        }
        return $datetime;*/
        return $datetime;
    }

    protected static function validateStatus(string $estado): string
    {
        if (!v::stringType()->length(6, 9)->validate($estado)) {
            throw new ValidatorException('Estado no es valido.', 400);
        }
        return $estado;
    }
    
    protected static function validateFoto(string $foto): string
    {
        if (!v::image()->validate($foto)) {
            throw new ValidatorException('Foto no es valida.', 400);
        }
        return $foto;
    }
}
