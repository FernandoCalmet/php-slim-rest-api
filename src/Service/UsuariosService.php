<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\UsuariosException;
use App\Repository\UsuariosRepository;
use \Firebase\JWT\JWT;

class UsuariosService extends BaseService
{
    const REDIS_KEY = 'user:%s';
    
    protected $usuariosRepository;

    public function __construct(UsuariosRepository $usuariosRepository)
    {
        $this->usuariosRepository = $usuariosRepository;
        $this->redisService = $redisService;
    }

    protected function checkAndGet(int $usuariosId)
    {
        return $this->usuariosRepository->checkAndGet($usuariosId);
    }

    public function getAll(): array
    {
        return $this->usuariosRepository->getAll();
    }

    public function getOne(int $usuariosId)
    {
        return $this->checkAndGet($usuariosId);
    }

    public function create($input)
    {
        $usuarios = json_decode(json_encode($input), false);

        return $this->usuariosRepository->create($usuarios);
    }

    public function update(array $input, int $usuariosId)
    {
        $usuarios = $this->checkAndGet($usuariosId);
        $data = json_decode(json_encode($input), false);

        return $this->usuariosRepository->update($usuarios, $data);
    }

    public function delete(int $usuariosId)
    {
        $this->checkAndGet($usuariosId);
        $this->usuariosRepository->delete($usuariosId);
    }

    public function getUsuarioFromCache(int $userId)
    {
        $redisKey = sprintf(self::REDIS_KEY, $userId);
        $key = $this->redisService->generateKey($redisKey);
        if ($this->redisService->exists($key)) {
            $data = $this->redisService->get($key);
            $user = json_decode(json_encode($data), false);
        } else {
            $user = $this->getUsuarioFromDb($userId);
            $this->redisService->setex($key, $user);
        }

        return $user;
    }

    public function search(string $usersName): array
    {
        return $this->usuariosRepository->search($usersName);
    }

    public function login(?array $input): string
    {
        $data = json_decode(json_encode($input), false);
        if (!isset($data->email)) {
            throw new UsuariosException('The field "email" is required.', 400);
        }
        if (!isset($data->password)) {
            throw new UsuariosException('The field "password" is required.', 400);
        }
        $password = hash('sha512', $data->password);
        $user = $this->usuariosRepository->loginUsuario($data->email, $password);
        $token = array(
            'sub' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'iat' => time(),
            'exp' => time() + (7 * 24 * 60 * 60),
        );

        return JWT::encode($token, getenv('SECRET_KEY'));
    }
}
