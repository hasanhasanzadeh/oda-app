<?php
namespace App\Services;


use App\Repositories\Interfaces\PostRepositoryInterface;

readonly class PostService
{
    public function __construct(private PostRepositoryInterface $postRepository)
    {
    }

    public function all(array $filters=[])
    {
        return $this->postRepository->all($filters);
    }

    public function findBySlug(string $slug)
    {
        return $this->postRepository->findBySlug($slug);
    }

    public function find($id)
    {
        return $this->postRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->postRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->postRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->postRepository->delete($id);
    }
}
