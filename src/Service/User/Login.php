<?php

declare(strict_types=1);

namespace App\Service\User;

use Firebase\JWT\JWT;

final class Login extends Base
{
    public function login(array $input): string
    {
        $data = json_decode((string) json_encode($input), false);
        if (!isset($data->email)) {
            throw new \App\Exception\UserException('The field "email" is required.', 400);
        }
        if (!isset($data->password)) {
            throw new \App\Exception\UserException('The field "password" is required.', 400);
        }
        $password = hash('sha512', $data->password);
        $user = $this->userRepository->login($data->email, $password);
        $token = [
            'sub' => $user->getId(),
            'email' => $user->getEmail(),
            'name' => $user->getName(),
            'iat' => time(),
            'exp' => time() + (7 * 24 * 60 * 60),
        ];

        if (self::isLoggerEnabled() === true) {
            $this->loggerService->setInfo('The user with the ID ' . $user->getId() . ' has logged in successfully.');
        }

        return JWT::encode($token, $_SERVER['SECRET_KEY']);
    }
}
