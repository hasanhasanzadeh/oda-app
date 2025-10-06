<?php
namespace App\Services;

use App\Repositories\Interfaces\SettingRepositoryInterface;

readonly class SettingService
{
    public function __construct(private SettingRepositoryInterface $settingRepository)
    {
    }

    public function all(array $filters=[])
    {
        return $this->settingRepository->all($filters);
    }

    public function find($id)
    {
        return $this->settingRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->settingRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->settingRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->settingRepository->delete($id);
    }

    public function first()
    {
        return $this->settingRepository->first();
    }
}
