<?php
namespace App\Services;


use App\Repositories\Interfaces\NotificationRepositoryInterface;

readonly class NotificationService
{
    public function __construct(private NotificationRepositoryInterface $notificationRepository)
    {
    }

    public function all(array $filters=[])
    {
        return $this->notificationRepository->all($filters);
    }

    public function findAndDelete($id)
    {
        return $this->notificationRepository->findAndDelete($id);
    }

    public function create(array $data)
    {
        return $this->notificationRepository->create($data);
    }
}
