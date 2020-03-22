<?php

declare(strict_types=1);

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

    protected function checkAndGet(int $rolesId)
    {
        return $this->rolesRepository->checkAndGet($rolesId);
    }

    public function getAll(): array
    {
        return $this->rolesRepository->getAll();
    }

    public function getOne(int $rolesId)
    {
        return $this->checkAndGet($rolesId);
    }

    public function create($input)
    {
        $roles = json_decode(json_encode($input), false);

        return $this->rolesRepository->create($roles);
    }

    public function update(array $input, int $rolesId)
    {
        $roles = $this->checkAndGet($rolesId);
        $data = json_decode(json_encode($input), false);

        return $this->rolesRepository->update($roles, $data);
    }

    public function delete(int $rolesId)
    {
        $this->checkAndGet($rolesId);
        $this->rolesRepository->delete($rolesId);
    }

    public function search(string $rolesName): array
    {
        return $this->rolesRepository->search($rolesName);
    }
}
