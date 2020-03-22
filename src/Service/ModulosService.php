<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\ModulosException;
use App\Repository\ModulosRepository;

class ModulosService extends BaseService
{
    protected $modulosRepository;

    public function __construct(ModulosRepository $modulosRepository)
    {
        $this->modulosRepository = $modulosRepository;
    }

    protected function checkAndGet(int $modulosId)
    {
        return $this->modulosRepository->checkAndGet($modulosId);
    }

    public function getAll(): array
    {
        return $this->modulosRepository->getAll();
    }

    public function getOne(int $modulosId)
    {
        return $this->checkAndGet($modulosId);
    }

    public function create($input)
    {
        $modulos = json_decode(json_encode($input), false);

        return $this->modulosRepository->create($modulos);
    }

    public function update(array $input, int $modulosId)
    {
        $modulos = $this->checkAndGet($modulosId);
        $data = json_decode(json_encode($input), false);

        return $this->modulosRepository->update($modulos, $data);
    }

    public function delete(int $modulosId)
    {
        $this->checkAndGet($modulosId);
        $this->modulosRepository->delete($modulosId);
    }

    public function search(string $modulosName): array
    {
        return $this->modulosRepository->search($modulosName);
    }
}
