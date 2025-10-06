<?php
namespace App\Services;


use App\Repositories\Interfaces\ContentRepositoryInterface;

readonly class ContentService
{
    public function __construct(private ContentRepositoryInterface $contentRepository)
    {
    }

    public function all(array $filters=[])
    {
        return $this->contentRepository->all($filters);
    }

    public function find($id)
    {
        return $this->contentRepository->find($id);
    }

    public function getByType($type)
    {
        return $this->contentRepository->getByType($type);
    }

    public function create(array $data)
    {
        return $this->contentRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->contentRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->contentRepository->delete($id);
    }
}
