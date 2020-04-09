<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\PermisosException;
use App\Repository\PermisosRepository;

class PermisosService extends BaseService
{
    const REDIS_KEY = 'permiso:%s';
    
    protected $permisosRepository;

    protected $redisService;

    public function __construct(PermisosRepository $permisosRepository, RedisService $redisService)
    {
        $this->permisosRepository = $permisosRepository;
        $this->redisService = $redisService;
    }

    protected function getPermisosRepository(): PermisosRepository
    {
        return $this->permisosRepository;
    }

    protected function checkAndGet(int $permisosId)
    {
        return $this->getPermisosRepository()->checkAndGet($permisosId);
    }   

    public function getAllPermisos(): array
    {
        return $this->getPermisosRepository()->getAllPermisos();
    }

    public function getAll(): array
    {
        return $this->getPermisosRepository()->getAll();
    }

    public function getOne(int $permisosId)
    {
        if (self::isRedisEnabled() === true) {
            $permiso = $this->getFromCache($permisosId);
        } else {
            $permiso = $this->getFromDb($permisosId);
        }
        return $permiso;
    }

    public function create(array $input)
    {
        $permiso = new \stdClass();
        $data = json_decode(json_encode($input), false);

        if (empty($data->id_rol)) {
            throw new PermisosException('Debes seleccionar el ID del Rol.', 400);
        }
        $permiso->id_rol = self::validateId($data->id_rol); 

        if (empty($data->id_operacion)) {
            throw new PermisosException('Debes seleccionar el ID de la Operación.', 400);
        }
        $permiso->id_operacion = self::validateId($data->id_operacion); 

        $permisos = $this->getPermisosRepository()->create($permiso);
        
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($permisos->id, $permisos);
        }

        return $permisos;
    }

    public function update(array $input, int $permisosId)
    {
        $permiso = $this->getFromDb($permisosId);
        $data = json_decode(json_encode($input), false);

        if (!isset($data->id_rol)) {
            throw new PermisosException('Debes seleccionar el ID del Rol.', 400);
        }
        if (isset($data->id_rol)) {
            $permiso->id_rol = self::validateId($data->id_rol);
        }

        if (!isset($data->id_operacion)) {
            throw new PermisosException('Debes seleccionar el ID de la Operación.', 400);
        }
        if (isset($data->id_operacion)) {
            $permiso->id_operacion = self::validateId($data->id_operacion);
        }    

        $permisos = $this->getPermisosRepository()->update($permiso);

        if (self::isRedisEnabled() === true) {
            $this->saveInCache($permisos->id, $permisos);
        }

        return $permisos;
    }

    public function delete(int $permisosId)
    {
        $this->getFromDb($permisosId);
        $data = $this->getPermisosRepository()->delete($permisosId);
        
        if (self::isRedisEnabled() === true) {
            $this->deleteFromCache($permisosId);
        }

        return $data;
    }

    public function search($permisosId): array
    {
        return $this->getPermisosRepository()->search($permisosId);
    }

    protected function getFromDb(int $permisosId)
    {
        return $this->getPermisosRepository()->checkAndGet($permisosId);
    }   

    public function getFromCache(int $permisosId)
    {
        $redisKey = sprintf(self::REDIS_KEY, $permisosId);
        $key = $this->redisService->generateKey($redisKey);
        if ($this->redisService->exists($key)) {
            $permiso = $this->redisService->get($key);
        } else {
            $permiso = $this->getFromDb($permisosId);
            $this->redisService->setex($key, $permiso);
        }
        return $permiso;
    }

    public function saveInCache($permisosId, $permisos)
    {
        $redisKey = sprintf(self::REDIS_KEY, $permisosId);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->setex($key, $permisos);
    }

    public function deleteFromCache($permisosId)
    {
        $redisKey = sprintf(self::REDIS_KEY, $permisosId);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->del($key);
    }
}
