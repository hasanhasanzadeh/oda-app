<?php
namespace App\Repositories;

use App\Helpers\Helper;
use App\Models\Service;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ServiceRepository implements ServiceRepositoryInterface
{
    public function all(array $filters = [])
    {
        $perPage = $filters['per_page']??10;
        $column = $filters['sort']??'created_at';
        $direction = $filters['direction']??'desc';

        $allowedPerPage = [10, 25, 50, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        $allowedColumns = ['title', 'id', 'status', 'created_at'];
        if (!in_array($column, $allowedColumns)) {
            $column = 'created_at';
        }
        $services = Service::query();

        if ($keyword = request('search')) {
            $services->where('title', 'LIKE', "%{$keyword}%");
        }
        if ($status = request('status')) {
            $services->where('status', 'LIKE', "%{$status}%");
        }
        if (!empty($filters['from_date']) || !empty($filters['to_date'])) {
            $from_date = $filters['from_date'] ?? null;
            $to_date = $filters['to_date'] ?? null;

            $services = $services->when($from_date, fn($q) => $q->whereDate('created_at', '>=', $from_date))
                ->when($to_date, fn($q) => $q->whereDate('created_at', '<=', $to_date));
        }
        return $services->orderBy($column, $direction === 'asc' ? 'asc' : 'desc')->paginate($perPage);
    }

    public function find($id)
    {
        return Service::findOrFail($id);
    }

    public function create(array $data)
    {
        $service = Service::create($data);
        if (isset($data['image'])) {
            $path = str_replace('public', 'storage', $data['image']->store('public/services'));
            $service->photo()->create(['path' => $path]);
        }
        return $service;
    }

    public function update($id, array $data)
    {
        $service = Service::findOrFail($id);
        $service->update($data);
        if (isset($data['image'])) {
            if ($service->photo) {
                Helper::deleteFile($service->photo->url);
                $service->photo()->delete();
            }
            $path = str_replace('public', 'storage', $data['image']->store('public/services'));
            $service->photo()->create(['path' => $path]);
        }
        return $service;
    }

    public function delete($id)
    {
        $service = Service::findOrFail($id);
        if ($service->photo) {
                Helper::deleteFile($service->photo->url);
                $service->photo()->delete();
        }
        return $service->delete();
    }
}
