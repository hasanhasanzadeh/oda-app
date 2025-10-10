<?php

namespace App\Repositories\Interfaces;

interface NotificationRepositoryInterface
{
    public function all(array $filters);

    public function findAndDelete($id);

    public function create(array $data);
}
