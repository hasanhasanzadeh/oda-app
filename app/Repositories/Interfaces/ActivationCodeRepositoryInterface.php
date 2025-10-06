<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface ActivationCodeRepositoryInterface
{
    public function create(User $user);
    public function findByCode($code,$userId);
    public function expiredCode($userId);
    public function deleteAll($userId);

}
