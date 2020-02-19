<?php declare(strict_types=1);

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

    protected function checkAndGetPermisos(int $permisosId)
    {
        return $this->permisosRepository->checkAndGetPermisos($permisosId);
    }

    public function getAllPermisos(): array
    {
        return $this->permisosRepository->getAllPermisos();
    }

    public function getPermisos(int $permisosId)
    {
        return $this->checkAndGetPermisos($permisosId);
    }

    public function createPermisos($input)
    {
        $permisos = json_decode(json_encode($input), false);

        return $this->permisosRepository->createPermisos($permisos);
    }

    public function updatePermisos(array $input, int $permisosId)
    {
        $permisos = $this->checkAndGetPermisos($permisosId);
        $data = json_decode(json_encode($input), false);

        return $this->permisosRepository->updatePermisos($permisos, $data);
    }

    public function deletePermisos(int $permisosId)
    {
        $this->checkAndGetPermisos($permisosId);
        $this->permisosRepository->deletePermisos($permisosId);
    }
}
