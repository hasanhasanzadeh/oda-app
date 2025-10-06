<?php

namespace App\Repositories\Interfaces;

interface AuthRepositoryInterface
{
    public function login(array $data);
    public function findByMobile($mobile);
    public function create(array $data);

    public function logout();

    public function getProfile();

}
