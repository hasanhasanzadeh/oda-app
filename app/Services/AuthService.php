<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;

readonly class AuthService
{
    public function __construct(private AuthRepositoryInterface $authRepository)
    {
    }

    public function findByMobile($mobil)
    {
        return $this->authRepository->findByMobile($mobil);
    }

    public function create(array $data)
    {
        return $this->authRepository->create($data);
    }

    public function login(array $credentials): false|User
    {
        return $this->authRepository->login($credentials);
    }

    public function logout()
    {
        return $this->authRepository->logout();
    }

    public function getProfile()
    {
        return $this->authRepository->getProfile();
    }
}
