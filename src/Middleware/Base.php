<?php

declare(strict_types=1);

namespace App\Middleware;

use Firebase\JWT\JWT;

abstract class Base
{
    protected function checkToken(string $token): object
    {
        try {
            return JWT::decode($token, $_SERVER['SECRET_KEY'], ['HS256']);
        } catch (\UnexpectedValueException $exception) {
            throw new \App\Exception\AuthException('Forbidden: you are not authorized.', 403);
        }
    }
}
