<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\ModulosException;
use App\Repository\ModulosRepository;

class ModulosService extends BaseService
{
    const REDIS_KEY = 'modulo:%s';
    
    protected $modulosRepository;

    protected $redisService;

    public function __construct(ModulosRepository $modulosRepository, RedisService $redisService)
    {
        $this->modulosRepository = $modulosRepository;
        $this->redisService = $redisService;
    }

    protected function getModulosRepository(): ModulosRepository
    {
        return $this->modulosRepository;
    }

    protected function checkAndGet(int $modulosId)
    {
        return $this->getModulosRepository()->checkAndGet($modulosId);
    }    

    public function getAllModulos(): array
    {
        return $this->getModulosRepository()->getAllModulos();
    }

    public function getAll(): array
    {
        return $this->getModulosRepository()->getAll();
    }

    public function getOne(int $modulosId)
    {
        if (self::isRedisEnabled() === true) {
            $modulo = $this->getFromCache($modulosId);
        } else {
            $modulo = $this->getFromDb($modulosId);
        }
        return $modulo;
    }

    public function create(array $input)
    {
        $modulo = new \stdClass();
        $data = json_decode(json_encode($input), false);

        if (empty($data->nombre)) {
            throw new ModulosException('Debes ingresar un Nombre.', 400);
        }
        $modulo->nombre = self::validateNombre($data->nombre);     

        $modulos = $this->getModulosRepository()->create($modulo);
        
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($modulos->id, $modulos);
        }

        return $modulos;
    }

    public function update(array $input, int $modulosId)
    {
        $modulo = $this->getFromDb($modulosId, (int) $input['decoded']->sub);
        $data = json_decode(json_encode($input), false);

        if (!isset($data->nombre)) {
            throw new ModulosException('Debes ingresar un Nombre.', 400);
        }
        if (isset($data->nombre)) {
            $modulo->nombre = self::validateNombre($data->nombre);
        }           

        $modulos = $this->getModulosRepository()->update($modulo);
        
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($modulos->id, $modulos);
        }

        return $modulos;
    }

    public function delete(int $modulosId)
    {
        $this->getFromDb($modulosId);
        $data = $this->getModulosRepository()->delete($modulosId);
        if (self::isRedisEnabled() === true) {
            $this->deleteFromCache($modulosId);
        }
        return $data;
    }

    public function search(string $modulosNombre): array
    {
        return $this->getModulosRepository()->search($modulosNombre);
    }

    protected function getFromDb(int $modulosId)
    {
        return $this->getModulosRepository()->checkAndGet($modulosId);
    }  

    public function getFromCache(int $modulosId)
    {
        $redisKey = sprintf(self::REDIS_KEY, $modulosId);
        $key = $this->redisService->generateKey($redisKey);
        if ($this->redisService->exists($key)) {
            $modulo = $this->redisService->get($key);
        } else {
            $modulo = $this->getFromDb($modulosId);
            $this->redisService->setex($key, $modulo);
        }
        return $modulo;
    }

    public function saveInCache($modulosId, $modulos)
    {
        $redisKey = sprintf(self::REDIS_KEY, $modulosId);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->setex($key, $modulos);
    }

    public function deleteFromCache($modulosId)
    {
        $redisKey = sprintf(self::REDIS_KEY, $modulosId);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->del($key);
    }
}
