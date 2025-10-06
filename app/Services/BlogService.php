<?php
namespace App\Services;

use App\Repositories\Interfaces\BlogRepositoryInterface;

readonly class BlogService
{
    public function __construct(private BlogRepositoryInterface $blogRepository)
    {
    }

    public function all(array $filters=[])
    {
        return $this->blogRepository->all($filters);
    }

    public function getTake(int $number=6)
    {
        return $this->blogRepository->getTake($number);
    }

    public function find($id)
    {
        return $this->blogRepository->find($id);
    }

    public function findBySlug($slug)
    {
        return $this->blogRepository->findBySlug($slug);
    }

    public function create(array $data)
    {
        return $this->blogRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->blogRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->blogRepository->delete($id);
    }
}
