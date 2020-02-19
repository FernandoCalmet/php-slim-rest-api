<?php declare(strict_types=1);

namespace App\Service;

use App\Exception\UsuariosException;
use App\Repository\UsuariosRepository;

class UsuariosService extends BaseService
{
    protected $usuariosRepository;

    public function __construct(UsuariosRepository $usuariosRepository)
    {
        $this->usuariosRepository = $usuariosRepository;
    }

    protected function checkAndGetUsuarios(int $usuariosId)
    {
        return $this->usuariosRepository->checkAndGetUsuarios($usuariosId);
    }

    public function getAllUsuarios(): array
    {
        return $this->usuariosRepository->getAllUsuarios();
    }

    public function getUsuarios(int $usuariosId)
    {
        return $this->checkAndGetUsuarios($usuariosId);
    }

    public function createUsuarios($input)
    {
        $usuarios = json_decode(json_encode($input), false);

        return $this->usuariosRepository->createUsuarios($usuarios);
    }

    public function updateUsuarios(array $input, int $usuariosId)
    {
        $usuarios = $this->checkAndGetUsuarios($usuariosId);
        $data = json_decode(json_encode($input), false);

        return $this->usuariosRepository->updateUsuarios($usuarios, $data);
    }

    public function deleteUsuarios(int $usuariosId)
    {
        $this->checkAndGetUsuarios($usuariosId);
        $this->usuariosRepository->deleteUsuarios($usuariosId);
    }
}
