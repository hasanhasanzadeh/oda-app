<?php
namespace App\Repositories;

use App\Helpers\Helper;
use App\Models\Symbol;
use App\Repositories\Interfaces\SymbolRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SymbolRepository implements SymbolRepositoryInterface
{
    public function all(array $filters = []): LengthAwarePaginator
    {
        $perPage = $filters['per_page']??10;
        $column = $filters['sort']??'created_at';
        $direction = $filters['direction']??'desc';

        $allowedPerPage = [10, 25, 50, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        $allowedColumns = ['id','title','status', 'created_at'];
        if (!in_array($column, $allowedColumns)) {
            $column = 'created_at';
        }
        $data = Symbol::query();

        if (!empty($filters['from_date']) || !empty($filters['to_date'])) {
            $from_date = $filters['from_date'] ?? null;
            $to_date = $filters['to_date'] ?? null;

            $data = $data->when($from_date, fn($q) => $q->whereDate('created_at', '>=', $from_date))
                ->when($to_date, fn($q) => $q->whereDate('created_at', '<=', $to_date));
        }

        if (!empty(request('search'))) {
            $data->where(function ($q) use ($filters) {
                $q->where('title', 'LIKE', '%' . request('search') . '%');
            });
        }
        if ($status = request('status')) {
            $data->where('status', 'LIKE', "%{$status}%");
        }
        return $data->orderBy($column, $direction === 'asc' ? 'asc' : 'desc')->paginate($perPage);
    }

    public function find($id)
    {
        return Symbol::findOrFail($id);
    }

    public function create(array $data)
    {
        $symbol =  Symbol::create($data);
        if (isset($data['image'])) {
            $path = str_replace('public', 'storage', $data['image']->store('public/symbols'));
            $symbol->photo()->create(['path' => $path]);
        }
        return $symbol;
    }

    public function update($id, array $data)
    {
        $symbol = Symbol::findOrFail($id);
        $symbol->update($data);
        if (isset($data['image'])) {
            if ($symbol->photo) {
                Helper::deleteFile($symbol->photo->url);
                $symbol->photo()->delete();
            }
            $path = str_replace('public', 'storage', $data['image']->store('public/symbols'));
            $symbol->photo()->create(['path' => $path]);
        }
        return $symbol;
    }

    public function delete($id)
    {
        $symbol = Symbol::findOrFail($id);
        if ($symbol->photo) {
                Helper::deleteFile($symbol->photo->url);
                $symbol->photo()->delete();
        }
        return $symbol->delete();
    }
}
