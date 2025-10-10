<?php
namespace App\Repositories;

use App\Models\Notification;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class NotificationRepository implements NotificationRepositoryInterface
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
        $allowedColumns = ['title', 'status', 'id', 'created_at'];
        if (!in_array($column, $allowedColumns)) {
            $column = 'created_at';
        }
        $notifications = Notification::query();

        if ($keyword = request('search')) {
            $notifications->where('title', 'LIKE', "%{$keyword}%");
        }
        if ($status = request('status')) {
            $notifications->where('status', 'LIKE', "%{$status}%");
        }
        return $notifications->where('user_id',auth()->user()->id)->orderBy($column, $direction === 'asc' ? 'asc' : 'desc')->paginate($perPage);
    }

    public function findAndDelete($id)
    {
        return Notification::where('user_id',auth()->user()->id)->findOrFail($id)->delete();
    }

    public function create(array $data)
    {
        return Notification::create($data);
    }
}
