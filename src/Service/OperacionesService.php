<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\OperacionesException;
use App\Repository\OperacionesRepository;

class OperacionesService extends BaseService
{
    const REDIS_KEY = 'operacion:%s';
    
    protected $operacionesRepository;

    protected $redisService;

    public function __construct(OperacionesRepository $operacionesRepository, RedisService $redisService)
    {
        $this->operacionesRepository = $operacionesRepository;
        $this->redisService = $redisService;
    }

    protected function getOperacionesRepository(): OperacionesRepository
    {
        return $this->operacionesRepository;
    }

    protected function checkAndGet(int $operacionesId)
    {
        return $this->getOperacionesRepository()->checkAndGet($operacionesId);
    }    

    public function getAllOperaciones(): array
    {
        return $this->getOperacionesRepository()->getAllOperaciones();
    }

    public function getAll(): array
    {
        return $this->getOperacionesRepository()->getAll();
    }

    public function getOne(int $operacionesId)
    {
        if (self::isRedisEnabled() === true) {
            $operacion = $this->getFromCache($operacionesId);
        } else {
            $operacion = $this->getFromDb($operacionesId);
        }
        return $operacion;
    }

    public function create(array $input)
    {
        $operacion = new \stdClass();
        $data = json_decode(json_encode($input), false);

        if (empty($data->id_modulo)) {
            throw new OperacionesException('Debes seleccionar un Modulo.', 400);
        }
        $operacion->id_modulo = self::validateId($data->id_modulo); 

        if (empty($data->nombre)) {
            throw new OperacionesException('Debes ingresar el Nombre de la Operación.', 400);
        }
        $operacion->nombre = self::validateNombre($data->nombre);      
        
        $operaciones = $this->getOperacionesRepository()->create($operacion);
        
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($operaciones->id, $operaciones);
        }

        return $operaciones;
    }

    public function update(array $input, int $operacionesId)
    {
        $operacion = $this->getFromDb($operacionesId);
        $data = json_decode(json_encode($input), false);

        if (!isset($data->id_modulo)) {
            throw new OperacionesException('Debes seleccionar un Modulo.', 400);
        }        
        if (isset($data->id_modulo)) {
            $operacion->id_modulo = self::validateId($data->id_modulo);
        }
        
        if (!isset($data->nombre)) {
            throw new OperacionesException('Debes ingresar el Nombre de la Operación.', 400);
        }  
        if (isset($data->nombre)) {
            $operacion->nombre = self::validateNombre($data->nombre);
        }  
        
        $operaciones = $this->getOperacionesRepository()->update($operacion);
        
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($operaciones->id, $operaciones);
        }

        return $operaciones;
    }

    public function delete(int $operacionesId)
    {
        $this->getFromDb($operacionesId);
        $data = $this->getOperacionesRepository()->delete($operacionesId);
        
        if (self::isRedisEnabled() === true) {
            $this->deleteFromCache($operacionesId);
        }
        
        return $data;
    }

    public function search($operacionesName): array
    {
        return $this->getOperacionesRepository()->search($operacionesName);
    }

    protected function getFromDb(int $operacionesId)
    {
        return $this->getOperacionesRepository()->checkAndGet($operacionesId);
    }

    public function getFromCache(int $operacionesId)
    {
        $redisKey = sprintf(self::REDIS_KEY, $operacionesId);
        $key = $this->redisService->generateKey($redisKey);
        if ($this->redisService->exists($key)) {
            $operacion = $this->redisService->get($key);
        } else {
            $operacion = $this->getFromDb($operacionesId);
            $this->redisService->setex($key, $operacion);
        }
        return $operacion;
    }

    public function saveInCache($operacionesId, $operaciones)
    {
        $redisKey = sprintf(self::REDIS_KEY, $operacionesId);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->setex($key, $operaciones);
    }

    public function deleteFromCache($operacionesId)
    {
        $redisKey = sprintf(self::REDIS_KEY, $operacionesId);
        $key = $this->redisService->generateKey($redisKey);
        $this->redisService->del($key);
    }
}
