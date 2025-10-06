<?php
namespace App\Services;


use App\Repositories\Interfaces\SymbolRepositoryInterface;

readonly class SymbolService
{
    public function __construct(private SymbolRepositoryInterface $symbolRepository)
    {
    }

    public function all(array $filters=[])
    {
        return $this->symbolRepository->all($filters);
    }

    public function find($id)
    {
        return $this->symbolRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->symbolRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->symbolRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->symbolRepository->delete($id);
    }
}
