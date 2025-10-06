<?php

namespace App\Services;


use App\Repositories\Interfaces\ProvinceRepositoryInterface;

readonly class ProvinceService
{

    public function __construct(private ProvinceRepositoryInterface $provinceRepository)
    {
    }

    public function all(array $filters)
    {
        return $this->provinceRepository->all($filters);
    }

    public function find($id)
    {
        return $this->provinceRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->provinceRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->provinceRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->provinceRepository->delete($id);
    }
}
