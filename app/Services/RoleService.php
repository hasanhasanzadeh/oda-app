<?php
namespace App\Services;

use App\Repositories\Interfaces\RoleRepositoryInterface;

readonly class RoleService
{
    public function __construct(private RoleRepositoryInterface $roleRepository)
    {
    }

    public function all(array $filters=[])
    {
        return $this->roleRepository->all($filters);
    }

    public function find($id)
    {
        return $this->roleRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->roleRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->roleRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->roleRepository->delete($id);
    }
}
