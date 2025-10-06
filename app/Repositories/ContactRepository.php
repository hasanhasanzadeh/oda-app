<?php
namespace App\Repositories;

use App\Models\Contact;
use App\Repositories\Interfaces\ContactRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContactRepository implements ContactRepositoryInterface
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

        $contacts = Contact::query();

        if ($keyword = request('search')) {
            $contacts->where('message', 'LIKE', "%{$keyword}%")
                ->orWhere('subject', 'LIKE', "%{$keyword}%")
                ->orWhere('full_name', 'LIKE', "%{$keyword}%")
                ->orWhere('mobile', 'LIKE', "%{$keyword}%")
                ->orWhere('ip_address', 'LIKE', "%{$keyword}%");
        }
        if (request()->has('read')) {
            $status = filter_var(request('read'), FILTER_VALIDATE_BOOLEAN);
            $contacts->where('read', $status);
        }
        if (!empty($filters['from_date']) || !empty($filters['to_date'])) {
            $from_date = $filters['from_date'] ?? null;
            $to_date = $filters['to_date'] ?? null;

            $contacts = $contacts->when($from_date, fn($q) => $q->whereDate('created_at', '>=', $from_date))
                ->when($to_date, fn($q) => $q->whereDate('created_at', '<=', $to_date));
        }
        return $contacts->orderBy($column, $direction === 'asc' ? 'asc' : 'desc')->paginate($perPage);

    }

    public function find($id)
    {
        return Contact::findOrFail($id);
    }

    public function create(array $data)
    {
        $data['ip_address'] = request()->ip();
        if (auth()->check()) {
            $data['user_id'] = auth()->user()->id;
            $data['full_name'] = auth()->user()->first_name.' '.auth()->user()->last_name;
            $data['mobile'] = auth()->user()->mobile;
            $data['email'] = auth()->user()->email;
        }
        return Contact::create($data);
    }

    public function update($id, array $data)
    {
        return Contact::findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return Contact::findOrFail($id)->delete();
    }
}
