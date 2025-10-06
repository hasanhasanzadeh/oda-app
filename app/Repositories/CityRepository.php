<?php
namespace App\Repositories;

use App\Models\Contact;
use App\Models\City;
use App\Repositories\Interfaces\CityRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CityRepository implements CityRepositoryInterface
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
        $allowedColumns = ['id','name', 'created_at'];
        if (!in_array($column, $allowedColumns)) {
            $column = 'created_at';
        }

        $cities = City::query();

        if ($keyword = request('search')) {
            $cities->where('name', 'LIKE', "%{$keyword}%");
            $cities->with('province')->where('name', 'LIKE', "%{$keyword}%")->orWhereHas('province', function ($query) use ($keyword) {
               $query->where('name', 'LIKE', "%{$keyword}%");
            });
        }
        if (!empty($filters['from_date']) || !empty($filters['to_date'])) {
            $from_date = $filters['from_date'] ?? null;
            $to_date = $filters['to_date'] ?? null;

            $cities = $cities->when($from_date, fn($q) => $q->whereDate('created_at', '>=', $from_date))
                ->when($to_date, fn($q) => $q->whereDate('created_at', '<=', $to_date));
        }
        return $cities->orderBy($column, $direction === 'asc' ? 'asc' : 'desc')->paginate($perPage);

    }

    public function find($id)
    {
        return City::findOrFail($id);
    }

    public function create(array $data)
    {
        return City::create($data);
    }

    public function delete($id)
    {
        return City::findOrFail($id)->delete();
    }

    public function update($id, array $data)
    {
        return City::find($id)->update($data);
    }
}
