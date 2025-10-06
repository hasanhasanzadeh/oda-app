<?php
namespace App\Repositories;

use App\Models\Qaq;
use App\Models\Rule;
use App\Repositories\Interfaces\QuestionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class QuestionRepository implements QuestionRepositoryInterface
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
        $questions = Qaq::query();
        if ($keyword = request('search')) {
            $questions->where('title', 'LIKE', "%{$keyword}%");
        }
        if ($status = request('status')) {
            $questions->where('status', 'LIKE', "%{$status}%");
        }
        if (!empty($filters['from_date']) || !empty($filters['to_date'])) {
            $from_date = $filters['from_date'] ?? null;
            $to_date = $filters['to_date'] ?? null;

            $questions = $questions->when($from_date, fn($q) => $q->whereDate('created_at', '>=', $from_date))
                ->when($to_date, fn($q) => $q->whereDate('created_at', '<=', $to_date));
        }
        return $questions->orderBy($column, $direction === 'asc' ? 'asc' : 'desc')->paginate($perPage);
    }

    public function getAll(array $filters = [])
    {

        $column = $filters['sort']??'created_at';
        $direction = $filters['direction']??'desc';

        $allowedColumns = ['title', 'id', 'status', 'created_at'];
        if (!in_array($column, $allowedColumns)) {
            $column = 'created_at';
        }
        $questions = Qaq::query();
        if ($keyword = request('search')) {
            $questions->where('title', 'LIKE', "%{$keyword}%");
        }
        if ($status = request('status')) {
            $questions->where('status', 'LIKE', "%{$status}%");
        }
        return $questions->orderBy($column, $direction === 'asc' ? 'asc' : 'desc')->get();
    }

    public function getStatusTrueAll()
    {
        return Qaq::where('status',true)->get();
    }

    public function find($id)
    {
        return Qaq::findOrFail($id);
    }

    public function create(array $data)
    {
        return Qaq::create($data);
    }

    public function update($id, array $data)
    {
        return Qaq::findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return Qaq::findOrFail($id)->delete();
    }
}
