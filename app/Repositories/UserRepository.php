<?php

namespace App\Repositories;

use App\Helpers\Helper;
use App\Models\Phone;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class UserRepository implements UserRepositoryInterface
{
    public function all(array $filters)
    {
        $perPage = $filters['per_page']??10;
        $column = $filters['sort']??'created_at';
        $direction = $filters['direction']??'desc';

        $allowedPerPage = [10, 25, 50, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        $allowedColumns = ['id', 'email','email_verified_at', 'created_at', 'role_type'];
        if (!in_array($column, $allowedColumns)) {
            $column = 'created_at';
        }

        $customers = User::query();

        if ($keyword = request('search')) {
            $customers = $customers->with('phones')->orWhereAny(['first_name', 'last_name'], 'LIKE', "%{$keyword}%")
                ->orWhereAny(['first_name_en', 'last_name_en'], 'LIKE', "%{$keyword}%")
                ->orWhereHas('phones', function ($query) use ($keyword) {
                    $query->where('number', 'LIKE', "%{$keyword}%");
            })->orWhere('email', 'LIKE', "%{$keyword}%")
                ->orWhere('national_code', 'LIKE', "%{$keyword}%");
        }
        if (request('role_type')) {
            $customers = $customers->where('role_type', request('role_type'));
        }
        if ($status = request('is_active')) {
            $customers->where('is_active', 'LIKE', "%{$status}%");
        }

        if (!empty($filters['from_date']) || !empty($filters['to_date'])) {
            $from_date = $filters['from_date'] ?? null;
            $to_date = $filters['to_date'] ?? null;

            $customers = $customers->when($from_date, fn($q) => $q->whereDate('created_at', '>=', $from_date))
                ->when($to_date, fn($q) => $q->whereDate('created_at', '<=', $to_date));
        }
        return $customers->with(['avatar'])->orderBy($column, $direction === 'asc' ? 'asc' : 'desc')->paginate($perPage);
    }

    public function find($id)
    {
        return User::findOrFail($id);
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try{
            $user = User::create($data);
            if (isset($data['avatar'])) {
                $path = str_replace('public', 'storage', $data['avatar']->store('public/avatars'));
                $user->avatar()->create(['path' => $path]);
            }
            $defaultPhoneIndex = $data['default_phone'];
            foreach ($data['phones'] as $index => $phoneData) {
                if (!empty($phoneData['number'])) {
                    $phone = new Phone($phoneData);
                    $phone->is_default = ($index == $defaultPhoneIndex);
                    $user->phones()->save($phone);
                }
            }
            foreach ($data['addresses'] as $addressData) {
                if (!empty($addressData['content'])) {
                    $user->addresses()->create($addressData);
                }
            }
            DB::commit();
            return $user;
        }catch (\Exception $exception){
            Log::error($exception->getMessage());
            DB::rollBack();
            return null;
        }
    }

    public function update($id, array $data)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);

            $userData = collect($data)->except(['phones', 'addresses', 'avatar', 'default_phone'])->toArray();
            if ($userData['password']==null) {
                $userData['password'] = $user->password;
            }
            $user->update($userData);

            $this->updateUserAvatar($user, $data);

            $this->updateUserPhones($user, $data);

            $this->updateUserAddresses($user, $data);

            DB::commit();
            return $user->fresh();

        } catch (\Exception $exception) {
            Log::error('User update failed', [
                'user_id' => $id,
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString()
            ]);
            DB::rollBack();
            return null;
        }
    }

    private function updateUserAvatar(User $user, array $data): void
    {
        if (!isset($data['avatar'])) {
            return;
        }
        if ($user->avatar) {
            Helper::deleteFile($user->avatar->address);
            $user->avatar->delete();
        }
        $path = str_replace('public', 'storage', $data['avatar']->store('public/avatars'));
        $user->avatar()->create(['path' => $path]);
    }

    private function updateUserPhones(User $user, array $data): void
    {
        if (!isset($data['phones']) || !is_array($data['phones'])) {
            return;
        }

        $user->phones()->delete();

        $defaultPhoneIndex = $data['default_phone'] ?? null;

        foreach ($data['phones'] as $index => $phoneData) {
            if (empty($phoneData['number'])) {
                continue;
            }

            $phoneData['is_default'] = ($index == $defaultPhoneIndex);
            $user->phones()->create($phoneData);
        }

        if ($user->phones()->count() > 0 && $user->phones()->where('is_default', true)->count() === 0) {
            $user->phones()->first()->update(['is_default' => true]);
        }
    }

    private function updateUserAddresses(User $user, array $data): void
    {
        if (!isset($data['addresses']) || !is_array($data['addresses'])) {
            return;
        }

        $user->addresses()->delete();

        foreach ($data['addresses'] as $addressData) {
            if (empty($addressData['content'])) {
                continue;
            }

            $user->addresses()->create($addressData);
        }
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        DB::beginTransaction();
        try{
            if ($user->avatar) {
                Helper::deleteFile($user->avatar->url);
                $user->avatar()->delete();
            }
            $user->phones()->delete();
            $user->addresses()->delete();
            $user->delete();
            DB::commit();
            return true;
        }catch (\Exception $exception){
            Log::error($exception->getMessage());
            DB::rollBack();
            return null;
        }
    }
}
