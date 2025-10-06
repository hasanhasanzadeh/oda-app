<?php
namespace App\Services;

use App\Repositories\Interfaces\PaymentRepositoryInterface;

readonly class PaymentService
{
    public function __construct(private PaymentRepositoryInterface $paymentRepository)
    {
    }

    public function all(array $filters=[])
    {
        return $this->paymentRepository->all($filters);
    }

    public function find($id,$me=false)
    {
        return $this->paymentRepository->find($id,$me);
    }

    public function delete($id)
    {
        return $this->paymentRepository->delete($id);
    }
}
