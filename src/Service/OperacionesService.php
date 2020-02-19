<?php declare(strict_types=1);

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

    protected function checkAndGetOperaciones(int $operacionesId)
    {
        return $this->operacionesRepository->checkAndGetOperaciones($operacionesId);
    }

    public function getAllOperaciones(): array
    {
        return $this->operacionesRepository->getAllOperaciones();
    }

    public function getOperaciones(int $operacionesId)
    {
        return $this->checkAndGetOperaciones($operacionesId);
    }

    public function createOperaciones($input)
    {
        $operaciones = json_decode(json_encode($input), false);

        return $this->operacionesRepository->createOperaciones($operaciones);
    }

    public function updateOperaciones(array $input, int $operacionesId)
    {
        $operaciones = $this->checkAndGetOperaciones($operacionesId);
        $data = json_decode(json_encode($input), false);

        return $this->operacionesRepository->updateOperaciones($operaciones, $data);
    }

    public function deleteOperaciones(int $operacionesId)
    {
        $this->checkAndGetOperaciones($operacionesId);
        $this->operacionesRepository->deleteOperaciones($operacionesId);
    }
}
