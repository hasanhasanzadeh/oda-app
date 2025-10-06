<?php
namespace App\Repositories;

use App\Models\Setting;
use App\Repositories\Interfaces\SettingRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SettingRepository implements SettingRepositoryInterface
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

        $allowedColumns = ['id','title', 'created_at'];
        if (!in_array($column, $allowedColumns)) {
            $column = 'created_at';
        }
        $panels = Setting::query();

        if ($keyword = request('search')) {
            $panels->where('title', 'LIKE', "%{$keyword}%");
        }

        return $panels->with(['favicon', 'logo','socialMedia'])->orderBy($column, $direction === 'asc' ? 'asc' : 'desc')->paginate(10);
    }

    public function find($id)
    {
        return Setting::with('socialMedia')->findOrFail($id);
    }

    public function first():? Setting
    {
        return Setting::with(['logo', 'favicon', 'socialMedia', 'meta', 'symbols'])->firstOrFail();
    }

    public function create(array $data)
    {
        return Setting::create($data);
    }

    public function update($id, array $data)
    {
        $setting = Setting::findOrFail($id);
        $setting->update($data);
        return $setting;
    }

    public function delete($id)
    {
        $setting = Setting::findOrFail($id);
        return $setting->delete();
    }
}
