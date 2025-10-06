<?php
namespace App\Services;

use App\Repositories\Interfaces\VisitRepositoryInterface;

readonly class VisitService
{
    public function __construct(private VisitRepositoryInterface $visitRepository)
    {
    }

    public function all(array $filter = [])
    {
        return $this->visitRepository->all($filter);
    }

    public function find($id)
    {
        return $this->visitRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->visitRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->visitRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->visitRepository->delete($id);
    }
}
