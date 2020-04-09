<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\UsuariosException;
use App\Repository\UsuariosRepository;
use \Firebase\JWT\JWT;

class UsuariosService extends BaseService
{
    const REDIS_KEY = 'usuario:%s';
    
    protected $usuariosRepository;

    protected $redisService;

    public function __construct(UsuariosRepository $usuariosRepository, RedisService $redisService)
    {
        $this->usuariosRepository = $usuariosRepository;
        $this->redisService = $redisService;
    }

    protected function getUsuariosRepository(): UsuariosRepository
    {
        return $this->usuariosRepository;
    }
   
    protected function checkAndGet(int $usuariosId)
    {
        return $this->getUsuariosRepository()->checkAndGet($usuariosId);
    }   

    public function getAllUsuarios(): array
    {
        return $this->getUsuariosRepository()->getAllUsuarios();
    }

    public function getAll(): array
    {
        return $this->getUsuariosRepository()->getAll();
    }

    public function getOne(int $usuariosId)
    {     
        if (self::isRedisEnabled() === true) {
            $usuario = $this->getFromCache($usuariosId);
        } else {
            $usuario = $this->getFromDb($usuariosId);
        }
        return $usuario;
    }

    public function create(array $input)
    {
        $usuario = new \stdClass();
        $data = json_decode(json_encode($input), false);     

        if(empty($data->correo)) {
            throw new UsuariosException('Debes ingresar tú Correo electronico.', 400);
        }
        $usuario->correo = self::validateEmail($data->correo); 
        $this->getUsuariosRepository()->checkByEmail($usuario->correo);

        if(empty($data->clave)) {
            throw new UsuariosException('Debes ingresar una Contraseña.', 400);
        }
        $usuario->clave = hash('sha512', $data->clave);

        if(empty($data->nombre)) {
            throw new UsuariosException('Debes ingresar tus Nombres.', 400);
        }
        $usuario->nombre = self::validateNombre($data->nombre);       
            
        $usuarios = $this->getUsuariosRepository()->create($usuario);

        if (self::isRedisEnabled() === true) {
            $this->saveInCache($usuarios->id, $usuarios);
        }

        return $usuarios;
    }

    public function update(array $input, int $usuariosId)
    {
        $usuario = $this->getFromDb($usuariosId);
        $data = json_decode(json_encode($input), false);

        if (!isset($data->correo)) {
            throw new UsuariosException('Debes ingresar tú Correo electronico.', 400);
        }       
        if (isset($data->correo)) {
            $usuario->correo = self::validateEmail($data->correo);
        }

        if (!isset($data->nombres)) {
            throw new UsuariosException('Debes ingresar tus Nombres.', 400);
        }
        if (isset($data->nombre)) {
            $usuario->nombre = self::validateNombre($data->nombre);
        }
     
        $usuarios = $this->getUsuariosRepository()->update($usuario);

        if (self::isRedisEnabled() === true) {
            $this->saveInCache($usuarios->id, $usuarios);
        }

        return $usuarios;
    }

    public function delete(int $usuariosId)
    {
        $this->getFromDb($usuariosId);
      
        $data = $this->getUsuariosRepository()->delete($usuariosId);

        if (self::isRedisEnabled() === true) {
            $this->deleteFromCache($usuariosId);
        }
        
        return $data;
    }
    
    public function search($usuarioNombre): array
    {
        return $this->getUsuariosRepository()->search($usuarioNombre);
    }

    public function login(?array $input): string
    {
        $data = json_decode(json_encode($input), false);

        if (!isset($data->correo)) {
            throw new UsuariosException('Debes ingresar tú correo', 400);
        }

        if (!isset($data->clave)) {
            throw new UsuariosException('Debes ingresar tú contraseña', 400);
        }
        $password = hash('sha512', $data->clave);

        $usuario = $this->getUsuariosRepository()->login($data->correo, $password);
        $token = array(
            'sub' => $usuario->id,
            'email' => $usuario->correo,
            'name' => $usuario->nombres,
            'iat' => time(),
            'exp' => time() + (7 * 24 * 60 * 60),
        );

        return JWT::encode($token, getenv('SECRET_KEY'));
    }

    public function changePassword(array $input, int $usuariosId)
    {
        $usuario = $this->getFromDb($usuariosId);
        $data = json_decode(json_encode($input), false);

        if (!isset($data->clave)) {
            throw new UsuariosException('Debes ingresar una contraseña nueva para poder realizar el cambio.', 400);
        }       
        if (isset($data->clave)) {
            $usuario->clave = hash('sha512', $data->clave);
        }
       
        $usuarios = $this->getUsuariosRepository()->changePassword($usuario);

        if (self::isRedisEnabled() === true) {
            $this->saveInCache($usuarios->id, $usuarios);
        }

        return $usuarios;
    }
  
    public function changeRole(array $input, int $usuariosId)
    {
        $usuario = $this->getFromDb($usuariosId);
        $data = json_decode(json_encode($input), false);

        if (!isset($data->id_rol)) {
            throw new UsuariosException('Debes seleccionar un Rol para realizar el cambio.', 400);
        }
       
        if (isset($data->id_rol)) {
            $usuario->id_rol = self::validateId($data->id_rol);
        }
       
        $usuarios = $this->getUsuariosRepository()->changeRole($usuario);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($usuarios->id, $usuarios);
        }

        return $usuarios;
    }

    protected function getFromDb(int $usuarioId)
    {
        return $this->getUsuariosRepository()->getUsuario($usuarioId);
    }

    public function getFromCache(int $usuariosId)
    {
        $redisKey = sprintf(self::REDIS_KEY, $usuariosId);
        $key = $this->redisService->generateKey($redisKey);
        if ($this->redisService->exists($key)) {
            $data = $this->redisService->get($key);
            $usuario = json_decode(json_encode($data), false);
        } else {
            $usuario = $this->getFromDb($usuariosId);
            $this->redisService->setex($key, $usuario);
        }
        return $usuario;
    }

    public function saveInCache($id, $usuario)
    {
        $redisKey = sprintf(self::REDIS_KEY, $id);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->setex($key, $usuario);
    }

    public function deleteFromCache($usuarioId)
    {
        $redisKey = sprintf(self::REDIS_KEY, $usuarioId);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->del($key);
    }
}
