<?php

namespace App\Repositories\Interfaces;

interface BlogRepositoryInterface
{
    public function all(array $filters);
    public function getTake(int $number);

    public function find($id);
    public function findBySlug($slug);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);
}
