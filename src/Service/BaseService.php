<?php declare(strict_types=1);

namespace App\Service;

use App\Exception\UsuariosException;
use App\Exception\RolesException;
use App\Exception\PromocionesException;
use App\Exception\PermisosException;
use App\Exception\OperacionesException;
use App\Exception\ModulosException;
use App\Exception\EventosException;
use App\Exception\DiscotecasException;
use App\Exception\CumpleaniosException;
use App\Exception\Asistencias_cumpleanioException;
use App\Exception\Asistencias_eventoException;
use Respect\Validation\Validator as v;

abstract class BaseService
{
    protected static function isRedisEnabled(): bool
    {
        return filter_var(getenv('REDIS_ENABLED'), FILTER_VALIDATE_BOOLEAN);
    }

    protected static function validateUserName(string $name): string
    {
        if (!v::alnum()->length(2, 100)->validate($name)) {
            throw new UsuariosException('Invalid name.', 400);
        }

        return $name;
    }

    protected static function validateEmail(string $emailValue): string
    {
        $email = filter_var($emailValue, FILTER_SANITIZE_EMAIL);
        if (!v::email()->validate($email)) {
            throw new UsuariosException('Invalid email', 400);
        }

        return $email;
    }

    protected static function validateRolName(string $name): string
    {
        if (!v::length(2, 100)->validate($name)) {
            throw new RolesException('Invalid name.', 400);
        }

        return $name;
    }

    protected static function validateRolStatus(int $status): int
    {
        if (!v::numeric()->between(0, 1)->validate($status)) {
            throw new RolesException('Invalid status', 400);
        }

        return $status;
    }

    protected static function validatePromocionName(string $name): string
    {
        if (!v::length(2, 50)->validate($name)) {
            throw new PromocionesException('The name of the promotion is invalid.', 400);
        }

        return $name;
    }
}
