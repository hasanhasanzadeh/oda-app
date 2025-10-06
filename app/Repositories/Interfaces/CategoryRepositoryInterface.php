<?php

namespace App\Repositories\Interfaces;

interface CategoryRepositoryInterface
{
    public function all(array $filters);

    public function find($id);
    public function findShow($id);
    public function findBySlug($slug);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);
}
