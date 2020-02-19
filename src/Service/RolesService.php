<?php declare(strict_types=1);

namespace App\Service;

use App\Exception\RolesException;
use App\Repository\RolesRepository;

class RolesService extends BaseService
{
    protected $rolesRepository;

    public function __construct(RolesRepository $rolesRepository)
    {
        $this->rolesRepository = $rolesRepository;
    }

    protected function checkAndGetRoles(int $rolesId)
    {
        return $this->rolesRepository->checkAndGetRoles($rolesId);
    }

    public function getAllRoles(): array
    {
        return $this->rolesRepository->getAllRoles();
    }

    public function getRoles(int $rolesId)
    {
        return $this->checkAndGetRoles($rolesId);
    }

    public function createRoles($input)
    {
        $roles = json_decode(json_encode($input), false);

        return $this->rolesRepository->createRoles($roles);
    }

    public function updateRoles(array $input, int $rolesId)
    {
        $roles = $this->checkAndGetRoles($rolesId);
        $data = json_decode(json_encode($input), false);

        return $this->rolesRepository->updateRoles($roles, $data);
    }

    public function deleteRoles(int $rolesId)
    {
        $this->checkAndGetRoles($rolesId);
        $this->rolesRepository->deleteRoles($rolesId);
    }
}
