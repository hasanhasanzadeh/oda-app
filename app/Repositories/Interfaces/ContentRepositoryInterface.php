<?php

namespace App\Repositories\Interfaces;

interface ContentRepositoryInterface
{
    public function all(array $filters);

    public function find($id);

    public function getByType($type);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);
}
