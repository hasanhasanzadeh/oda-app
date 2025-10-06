<?php

namespace App\Services;

use App\Repositories\Interfaces\CountryRepositoryInterface;

readonly class CountryService
{

    public function __construct(private CountryRepositoryInterface $countryRepository)
    {
    }

    public function all(array $filters)
    {
        return $this->countryRepository->all($filters);
    }

    public function find($id)
    {
        return $this->countryRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->countryRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->countryRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->countryRepository->delete($id);
    }
}
