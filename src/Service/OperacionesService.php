<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\OperacionesException;
use App\Repository\OperacionesRepository;

class OperacionesService extends BaseService
{
    protected $operacionesRepository;

    public function __construct(OperacionesRepository $operacionesRepository)
    {
        $this->operacionesRepository = $operacionesRepository;
    }

    protected function checkAndGet(int $operacionesId)
    {
        return $this->operacionesRepository->checkAndGet($operacionesId);
    }

    public function getAll(): array
    {
        return $this->operacionesRepository->getAll();
    }

    public function getOne(int $operacionesId)
    {
        return $this->checkAndGet($operacionesId);
    }

    public function create($input)
    {
        $operaciones = json_decode(json_encode($input), false);

        return $this->operacionesRepository->create($operaciones);
    }

    public function update(array $input, int $operacionesId)
    {
        $operaciones = $this->checkAndGet($operacionesId);
        $data = json_decode(json_encode($input), false);

        return $this->operacionesRepository->update($operaciones, $data);
    }

    public function delete(int $operacionesId)
    {
        $this->checkAndGet($operacionesId);
        $this->operacionesRepository->delete($operacionesId);
    }

    public function search(string $operacionesName): array
    {
        return $this->operacionesRepository->search($operacionesName);
    }
}
