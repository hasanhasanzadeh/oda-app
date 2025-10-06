<?php
namespace App\Services;


use App\Repositories\Interfaces\CityRepositoryInterface;

readonly class CityService
{
    public function __construct(private CityRepositoryInterface $cityRepository)
    {
    }

    public function all(array $filters=[])
    {
        return $this->cityRepository->all($filters);
    }

    public function find($id)
    {
        return $this->cityRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->cityRepository->create($data);
    }

    public function delete($id)
    {
        return $this->cityRepository->delete($id);
    }
}
