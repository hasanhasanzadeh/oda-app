<?php
namespace App\Services;


use App\Repositories\Interfaces\ContactRepositoryInterface;

readonly class ContactService
{
    public function __construct(private ContactRepositoryInterface $contactRepository)
    {
    }

    public function all(array $filters=[])
    {
        return $this->contactRepository->all($filters);
    }

    public function find($id)
    {
        return $this->contactRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->contactRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->contactRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->contactRepository->delete($id);
    }
}
