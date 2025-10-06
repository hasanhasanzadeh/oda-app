<?php

namespace App\Services;

use App\Repositories\Interfaces\ServiceRepositoryInterface;

readonly class ServiceService
{

    public function __construct(private ServiceRepositoryInterface $serviceRepository)
    {
    }

    public function all(array $filters)
    {
        return $this->serviceRepository->all($filters);
    }

    public function find($id)
    {
        return $this->serviceRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->serviceRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->serviceRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->serviceRepository->delete($id);
    }
}
