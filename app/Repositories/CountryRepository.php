<?php
namespace App\Repositories;

use App\Helpers\Helper;
use App\Models\Country;
use App\Repositories\Interfaces\CountryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CountryRepository implements CountryRepositoryInterface
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
        $allowedColumns = ['country_name', 'id', 'country_code','country_persian_name', 'created_at'];
        if (!in_array($column, $allowedColumns)) {
            $column = 'created_at';
        }
        $countries = Country::query();

        if ($keyword =  request('search')) {
            $countries->where('country_name', 'LIKE', "%{$keyword}%")
                ->orWhere('country_code', 'LIKE', "%{$keyword}%")
                ->orWhere('country_persian_name', 'LIKE', "%{$keyword}%");
        }
        if (!empty($filters['from_date']) || !empty($filters['to_date'])) {
            $from_date = $filters['from_date'] ?? null;
            $to_date = $filters['to_date'] ?? null;

            $countries = $countries->when($from_date, fn($q) => $q->whereDate('created_at', '>=', $from_date))
                ->when($to_date, fn($q) => $q->whereDate('created_at', '<=', $to_date));
        }
        return $countries->with(['flag','provinces'])->orderBy($column, $direction === 'asc' ? 'asc' : 'desc')->paginate($perPage);
    }

    public function find($id)
    {
        return Country::findOrFail($id);
    }

    public function create(array $data)
    {
        $country = Country::create($data);
        if (isset($data['flag'])) {
            $path = str_replace('public', 'storage', $data['flag']->store('public/flags'));
            $country->flag()->create(['path' => $path]);
        }
        if (isset($data['flag'])) {
            $path = str_replace('public', 'storage', $data['flag']->store('public/flags'));
            $country->flag()->create(['path' => $path]);
        }
        return $country;
    }

    public function update($id, array $data)
    {
        $country = Country::findOrFail($id);
        if (isset($data['flag'])) {
            if ($country->flag) {
                Helper::deleteFile($country->flag->url);
                $country->flag()->delete();
            }
            $path = str_replace('public', 'storage', $data['flag']->store('public/flags'));
            $country->flag()->create(['path' => $path]);
        }
        $country->update($data);
        return $country;
    }

    public function delete($id)
    {
        $country = Country::findOrFail($id);
        if ($country->flag) {
            Helper::deleteFile($country->flag->url);
            $country->flag()->delete();
        }
        return $country->delete();
    }
}
