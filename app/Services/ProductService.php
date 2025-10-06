<?php
namespace App\Services;


use App\Repositories\Interfaces\ProductRepositoryInterface;

readonly class ProductService
{
    public function __construct(private ProductRepositoryInterface $productRepository)
    {
    }

    public function all(array $filters=[])
    {
        return $this->productRepository->all($filters);
    }

    public function find($id)
    {
        return $this->productRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->productRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->productRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->productRepository->delete($id);
    }
}
