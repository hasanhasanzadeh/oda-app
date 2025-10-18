<?php
namespace App\Services;

use App\Repositories\Interfaces\PageRepositoryInterface;

readonly class PageService
{
    public function __construct(private PageRepositoryInterface $pageRepository)
    {
    }

    public function all(array $filters=[])
    {
        return $this->pageRepository->all($filters);
    }
    public function find($id)
    {
        return $this->pageRepository->find($id);
    }

    public function findBySlug($slug)
    {
        return $this->pageRepository->findBySlug($slug);
    }

    public function create(array $data)
    {
        return $this->pageRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->pageRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->pageRepository->delete($id);
    }
}
