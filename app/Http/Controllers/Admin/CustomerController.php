<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CustomerAllRequest;
use App\Http\Requests\Customer\CustomerCreateFormRequest;
use App\Http\Requests\Customer\CustomerCreateRequest;
use App\Http\Requests\Customer\CustomerDeleteRequest;
use App\Http\Requests\Customer\CustomerFindRequest;
use App\Http\Requests\Customer\CustomerUpdateFormRequest;
use App\Http\Requests\Customer\CustomerUpdateRequest;
use App\Models\Setting;
use App\Models\User;
use App\Services\SettingService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function __construct(readonly private UserService $userService)
    {
    }

    public function index(CustomerAllRequest $request)
    {
        $title = __('message.customers');
        $validated = $request->validated();
        $customers = $this->userService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.customer.index', [
            'title' => $title,
            'customers' => $customers,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }

    public function create(CustomerCreateFormRequest $request)
    {
        $title = __('message.customers');
        return view('admin.customer.create', compact(['title']));
    }


    public function store(CustomerCreateRequest $request)
    {
        $customer = $this->userService->create($request->validated());
        if ($customer) {
            toast(__('message.created'), 'success');
        }
        else{
            toast(__('message.problem'), 'error');
        }

        return redirect(session('previous_url')??route('customer.index'));
    }

    public function show(CustomerFindRequest $request, User $customer)
    {
        $title = __('message.show');

        return view('admin.customer.show', compact(['customer', 'title']));
    }

    public function edit(CustomerUpdateFormRequest $request, User $customer)
    {
        $title = __('message.edit');

        return view('admin.customer.edit', compact(['customer', 'title']));
    }

    public function update(CustomerUpdateRequest $request, User $customer)
    {
        $customer = $this->userService->update($customer->id,$request->validated());

        if ($customer) {
            toast(__('message.updated'), 'success');
        }
        else{
            toast(__('message.problem'), 'error');
        }

        return redirect(session('previous_url')??route('customer.index'));
    }

    public function destroy(CustomerDeleteRequest $request, User $customer)
    {
        if ($customer->avatar) {
            Helper::deleteFile($customer->avatar->url);
            $customer->avatar()->delete();
        }
        $customer->delete();

        toast(__('message.deleted'), 'error');

        return redirect(session('previous_url')??route('customer.index'));
    }

    public function search(Request $request): \Illuminate\Http\JsonResponse
    {
        $query = User::query();

        if ($request->filled('q')) {
            $query->with('phones')
                ->where('first_name', 'LIKE', '%' . $request->q . '%')
                ->orWhere('last_name', 'LIKE', '%' . $request->q . '%')
                ->orWhere('first_name_en', 'LIKE', '%' . $request->q . '%')
                ->orWhere('last_name_en', 'LIKE', '%' . $request->q . '%')
                ->orWhereHas('phones', function ($query) use ($request) {
                $query->where('number', 'LIKE', "%{$request->q}%");
            })->orWhere('national_code', 'LIKE', '%' . $request->q . '%')
                ->orWhere('email', 'LIKE', '%' . $request->q . '%');
        }

        $users = $query->get()->map(function ($user) {
            return [
                'id' => $user->id,
                'title' => $user->fullName,
                'subtitle' => $user->national_code ?? '',
                'avatar' => $user->avatar->address ?? '/images/user/avatar-profile.png',
            ];
        });

        return response()->json($users);
    }

}
