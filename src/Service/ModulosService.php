<?php declare(strict_types=1);

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

    protected function checkAndGetModulos(int $modulosId)
    {
        return $this->modulosRepository->checkAndGetModulos($modulosId);
    }

    public function getAllModulos(): array
    {
        return $this->modulosRepository->getAllModulos();
    }

    public function getModulos(int $modulosId)
    {
        return $this->checkAndGetModulos($modulosId);
    }

    public function createModulos($input)
    {
        $modulos = json_decode(json_encode($input), false);

        return $this->modulosRepository->createModulos($modulos);
    }

    public function updateModulos(array $input, int $modulosId)
    {
        $modulos = $this->checkAndGetModulos($modulosId);
        $data = json_decode(json_encode($input), false);

        return $this->modulosRepository->updateModulos($modulos, $data);
    }

    public function deleteModulos(int $modulosId)
    {
        $this->checkAndGetModulos($modulosId);
        $this->modulosRepository->deleteModulos($modulosId);
    }
}
