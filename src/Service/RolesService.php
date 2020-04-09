<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\RolesException;
use App\Repository\RolesRepository;

class RolesService extends BaseService
{
    const REDIS_KEY = 'rol:%s';
    
    protected $rolesRepository;

    protected $redisService;

    public function __construct(RolesRepository $rolesRepository, RedisService $redisService)
    {
        $this->rolesRepository = $rolesRepository;
        $this->redisService = $redisService;
    }

    protected function getRolesRepository(): RolesRepository
    {
        return $this->rolesRepository;
    }

    protected function checkAndGet(int $rolesId)
    {
        return $this->getRolesRepository()->checkAndGet($rolesId);
    }   

    public function getAllRoles(): array
    {
        return $this->getRolesRepository()->getAllRoles();
    }

    public function getAll(): array
    {
        return $this->getRolesRepository()->getAll();
    }

    public function getOne(int $rolesId)
    {
        if (self::isRedisEnabled() === true) {
            $rol = $this->getFromCache($rolesId);
        } else {
            $rol = $this->getFromDb($rolesId);
        }
        return $rol;
    }

    public function create(array $input)
    {
        $rol = new \stdClass();
        $data = json_decode(json_encode($input), false);

        if (empty($data->nombre)) {
            throw new RolesException('Debes ingresar un Nombre.', 400);
        }
        $rol->nombre = self::validateNombre($data->nombre);      
        
        $roles = $this->getRolesRepository()->create($rol);

        if (self::isRedisEnabled() === true) {
            $this->saveInCache($roles->id, $roles);
        }

        return $roles;
    }

    public function update(array $input, int $rolesId)
    {
        $rol = $this->getFromDb($rolesId);
        $data = json_decode(json_encode($input), false);
        
        if (!isset($data->nombre)) {
            throw new RolesException('Debes ingresar un Nombre.', 400);
        }
        if (isset($data->nombre)) {
            $rol->nombre = self::validateNombre($data->nombre);
        }  
                 
        $roles = $this->getRolesRepository()->update($rol);

        if (self::isRedisEnabled() === true) {
            $this->saveInCache($roles->id, $roles);
        }

        return $roles;
    }

    public function delete(int $rolId): string
    {
        $this->getFromDb($rolId);
        $data = $this->getRolesRepository()->delete($rolId);

        if (self::isRedisEnabled() === true) {
            $this->deleteFromCache($rolId);
        }
        
        return $data;
    }

    public function search($rolesName): array
    {        
        return $this->getRolesRepository()->search($rolesName);
    }

    protected function getFromDb(int $rolesId)
    {
        return $this->getRolesRepository()->checkAndGet($rolesId);
    }   

    public function getFromCache(int $rolesId)
    {
        $redisKey = sprintf(self::REDIS_KEY, $rolesId);
        $key = $this->redisService->generateKey($redisKey);
        if ($this->redisService->exists($key)) {
            $rol = $this->redisService->get($key);
        } else {
            $rol = $this->getFromDb($rolesId);
            $this->redisService->setex($key, $rol);
        }
        return $rol;
    }

    public function saveInCache($rolesId, $roles)
    {
        $redisKey = sprintf(self::REDIS_KEY, $rolesId);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->setex($key, $roles);
    }

    public function deleteFromCache($rolesId)
    {
        $redisKey = sprintf(self::REDIS_KEY, $rolesId);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->del($key);
    }
}
