<?php

namespace App\Services;

use App\Repositories\Interfaces\ActivationCodeRepositoryInterface;

readonly class ActivationCodeService
{
    public function __construct(private ActivationCodeRepositoryInterface $activationCodeRepository)
    {
    }

    public function find($code,$userId)
    {
        return $this->activationCodeRepository->findByCode($code,$userId);
    }

    public function expiredCode($userId)
    {
        return $this->activationCodeRepository->expiredCode($userId);
    }

    public function create($user)
    {
        return $this->activationCodeRepository->create($user);
    }

    public function delete($userId)
    {
        return $this->activationCodeRepository->deleteAll($userId);
    }
}
