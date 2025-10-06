<?php
namespace App\Services;


use App\Repositories\Interfaces\CategoryRepositoryInterface;

readonly class CategoryService
{
    public function __construct(private CategoryRepositoryInterface $categoryRepository)
    {
    }

    public function all(array $filters=[])
    {
        return $this->categoryRepository->all($filters);
    }

    public function find($id)
    {
        return $this->categoryRepository->find($id);
    }

    public function findShow($id)
    {
        return $this->categoryRepository->findShow($id);
    }

    public function findBySlug($slug)
    {
        return $this->categoryRepository->findBySlug($slug);
    }

    public function create(array $data)
    {
        return $this->categoryRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->categoryRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->categoryRepository->delete($id);
    }
}
