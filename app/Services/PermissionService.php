<?php
namespace App\Services;

use App\Repositories\Interfaces\PermissionRepositoryInterface;

readonly class PermissionService
{
    public function __construct(private PermissionRepositoryInterface $permissionRepository)
    {
    }

    public function all(array $filters=[])
    {
        return $this->permissionRepository->all($filters);
    }

    public function find($id)
    {
        return $this->permissionRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->permissionRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->permissionRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->permissionRepository->delete($id);
    }
}
