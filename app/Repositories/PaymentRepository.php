<?php
namespace App\Repositories;

use App\Models\Payment;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaymentRepository implements PaymentRepositoryInterface
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

        $allowedColumns = ['id','user_id', 'paymentable_id','paymentable_type','reference_id','transaction_id','amount', 'status', 'created_at'];
        if (!in_array($column, $allowedColumns)) {
            $column = 'created_at';
        }
        $data = Payment::query();

        if ($status = request('status')) {
            $data->where('status', $status);
        }
        if ($full_name = request('full_name')) {
            $data->with('user')->whereHas('user', function ($query) use ($full_name) {
                $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$full_name}%"]);
            });
        }
        if ( request()->has('me')) {
            $data->with('user')->whereHas('user', function ($query) {
                $query->where('id', auth()->user()->id);
            });
        }
        if (!empty($filters['from_date']) || !empty($filters['to_date'])) {
            $from_date = $filters['from_date'] ?? null;
            $to_date = $filters['to_date'] ?? null;

            $data = $data->when($from_date, fn($q) => $q->whereDate('created_at', '>=', $from_date))
                ->when($to_date, fn($q) => $q->whereDate('created_at', '<=', $to_date));
        }
        return $data->with(['user','paymentable'])->orderBy($column, $direction === 'asc' ? 'asc' : 'desc')->paginate($perPage);
    }

    public function find($id,$with=false)
    {
        if ($with) {
            $payment = Payment::with(['user','paymentable'])->whereHas('user',function ($query){
                $query->where('id',auth()->user()->id);
            })->findOrFail($id);
        }
        else{
            $payment = Payment::with(['user','paymentable'])->findOrFail($id);
        }
        return $payment;
    }

    /**
     * @throws Exception
     */
    public function delete($id):bool
    {
        Payment::findOrFail($id)->delete();
        return true;
    }
}
