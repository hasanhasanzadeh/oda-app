<?php
namespace App\Repositories;

use App\Models\Visit;
use App\Repositories\Interfaces\VisitRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class VisitRepository implements VisitRepositoryInterface
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

        $allowedColumns = ['id','ip_address','score', 'created_at'];
        if (!in_array($column, $allowedColumns)) {
            $column = 'created_at';
        }
        $data = Visit::query();

        if (isset($filters['visited_at'])) {
            if ($filters['visited_at']=='today') {
                $data = $data->whereDate('created_at',  Carbon::today());
            }
            elseif ($filters['visited_at']=='weekly') {
                $data = $data->whereBetween('created_at', [Carbon::now()->startOfWeek(),  Carbon::now()->endOfWeek()]);
            }
            elseif ($filters['visited_at']=='monthly') {
                $data = $data->whereMonth('created_at', Carbon::now()->month);
            }
            elseif ($filters['visited_at']=='yearly') {
                $data = $data->whereYear('created_at', Carbon::now()->year);
            }
        }

        if ($keyword = request('search')) {
            $data->with('user.phones')
                ->orWhereHas('user', function ($query) use ($keyword) {
                    $query->whereAny(['first_name', 'last_name'], 'LIKE', "%{$keyword}%")
                        ->orWhereAny(['first_name_en', 'last_name_en'], 'LIKE', "%{$keyword}%");
                })->orWhereHas('user.phones', function ($q) use ($keyword) {
                    $q->where('number', 'LIKE', "%{$keyword}%");
                })->orWhere('ip_address', 'LIKE', "%{$keyword}%")
                ->orWhere('url', 'LIKE', "%{$keyword}%");

        }

        if (!empty($filters['from_date']) || !empty($filters['to_date'])) {
            $from_date = $filters['from_date'] ?? null;
            $to_date = $filters['to_date'] ?? null;

            $data = $data->when($from_date, fn($q) => $q->whereDate('created_at', '>=', $from_date))
                ->when($to_date, fn($q) => $q->whereDate('created_at', '<=', $to_date));
        }

        return $data->orderBy($column, $direction === 'asc' ? 'asc' : 'desc')->paginate($perPage);
    }

    public function find($id)
    {
        return Visit::findOrFail($id);
    }

    public function create(array $data)
    {
        DB::transaction(function () use ($data) {
            $data['ip_address'] = request()->ip();
            $visit = Visit::where('ip_address', $data['ip_address'])->whereDate('created_at',today())->first();
            if ($visit) {
                $visit->score += 1;
                $visit->save();
                return $visit;
            }
            return Visit::create([
                'ip_address' => $data['ip_address'],
                'score' => 1
            ]);
        });
    }

    public function delete($id)
    {
        return Visit::findOrFail($id)->delete();
    }
}
