<?php
namespace App\Repositories;


use App\Models\Province;
use App\Repositories\Interfaces\ProvinceRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProvinceRepository implements ProvinceRepositoryInterface
{
    public function all(array $filters = []):LengthAwarePaginator
    {
        $perPage = $filters['per_page']??10;
        $column = $filters['sort']??'created_at';
        $direction = $filters['direction']??'desc';

        $allowedPerPage = [10, 25, 50, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        $allowedColumns = ['name', 'id', 'created_at'];
        if (!in_array($column, $allowedColumns)) {
            $column = 'created_at';
        }
        $provinces = Province::query();

        if ($keyword = request('search')) {
            $provinces->with('cities')
                ->where('name', 'LIKE', "%{$keyword}%")
                ->orWhere('cities', function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%{$keyword}%");
                });
        }
        if (!empty($filters['from_date']) || !empty($filters['to_date'])) {
            $from_date = $filters['from_date'] ?? null;
            $to_date = $filters['to_date'] ?? null;

            $provinces = $provinces->when($from_date, fn($q) => $q->whereDate('created_at', '>=', $from_date))
                ->when($to_date, fn($q) => $q->whereDate('created_at', '<=', $to_date));
        }
        return $provinces->orderBy($column, $direction === 'asc' ? 'asc' : 'desc')->paginate($perPage);
    }

    public function find($id)
    {
        return Province::findOrFail($id);
    }

    public function create(array $data)
    {
        return Province::create($data);
    }

    public function update($id, array $data)
    {
        return Province::findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return Province::findOrFail($id)->delete();
    }
}
