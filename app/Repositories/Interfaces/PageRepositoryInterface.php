<?php

namespace App\Repositories\Interfaces;

interface PageRepositoryInterface
{
    public function all(array $filters);

    public function find($id);
    public function findBySlug($slug);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);
}
