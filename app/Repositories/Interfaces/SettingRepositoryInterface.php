<?php

namespace App\Repositories\Interfaces;

interface SettingRepositoryInterface
{
    public function all(array $filters);

    public function find($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);
    public function first();
}
