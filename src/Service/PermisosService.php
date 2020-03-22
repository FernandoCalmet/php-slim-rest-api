<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\PermisosException;
use App\Repository\PermisosRepository;

class PermisosService extends BaseService
{
    protected $permisosRepository;

    public function __construct(PermisosRepository $permisosRepository)
    {
        $this->permisosRepository = $permisosRepository;
    }

    protected function checkAndGet(int $permisosId)
    {
        return $this->permisosRepository->checkAndGet($permisosId);
    }

    public function getAll(): array
    {
        return $this->permisosRepository->getAll();
    }

    public function getOne(int $permisosId)
    {
        return $this->checkAndGet($permisosId);
    }

    public function create($input)
    {
        $permisos = json_decode(json_encode($input), false);

        return $this->permisosRepository->create($permisos);
    }

    public function update(array $input, int $permisosId)
    {
        $permisos = $this->checkAndGet($permisosId);
        $data = json_decode(json_encode($input), false);

        return $this->permisosRepository->update($permisos, $data);
    }

    public function delete(int $permisosId)
    {
        $this->checkAndGet($permisosId);
        $this->permisosRepository->delete($permisosId);
    }

    public function search(int $permisosId): array
    {
        return $this->permisosRepository->search($permisosId);
    }
}
