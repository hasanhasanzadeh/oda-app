<?php

namespace App\Repositories\Interfaces;

interface QuestionRepositoryInterface
{
    public function all(array $filters);
    public function getAll(array $filters);
    public function getStatusTrueAll();

    public function find($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);
}
