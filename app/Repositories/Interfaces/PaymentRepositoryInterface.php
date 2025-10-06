<?php

namespace App\Repositories\Interfaces;

interface PaymentRepositoryInterface
{
    public function all(array $filters);

    public function find($id,bool $with=false);

    public function delete($id);
}
