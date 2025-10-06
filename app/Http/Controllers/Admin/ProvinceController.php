<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Province\ProvinceAllRequest;
use App\Http\Requests\Province\ProvinceCreateFormRequest;
use App\Http\Requests\Province\ProvinceCreateRequest;
use App\Http\Requests\Province\ProvinceDeleteRequest;
use App\Http\Requests\Province\ProvinceFindRequest;
use App\Http\Requests\Province\ProvinceUpdateFormRequest;
use App\Http\Requests\Province\ProvinceUpdateRequest;
use App\Models\Province;
use App\Models\Setting;
use App\Models\User;
use App\Services\ProvinceService;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{

    public function __construct(private readonly ProvinceService $provinceService)
    {
    }

    public function index(ProvinceAllRequest $request)
    {
        $title = __('message.provinces');
        $validated = $request->validated();
        $provinces = $this->provinceService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.province.index', [
            'title' => $title,
            'provinces' => $provinces,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }


    public function create(ProvinceCreateFormRequest $request)
    {
        $title = __('message.create');

        return view('admin.province.create', compact([ 'title',]));
    }

    public function store(ProvinceCreateRequest $request)
    {
        $province = new Province();
        $province->name = $request->province_name;
        $province->country_id = $request->country_id;
        $province->save();

        toast(__('message.created'), 'success');

        return redirect(session('previous_url')??route('provinces.index'));
    }


    public function show(ProvinceFindRequest $request,Province $province)
    {
        $title = __('message.show');

        return view('admin.province.show', compact([ 'title', 'province']));
    }


    public function edit(ProvinceUpdateFormRequest $request,Province $province)
    {
        $title = __('message.edit');

        return view('admin.province.edit', compact([ 'title', 'province']));
    }


    public function update(ProvinceUpdateRequest $request, Province $province)
    {
        $province->name = $request->province_name;
        $province->country_id = $request->country_id;
        $province->save();

        toast(__('message.created'), 'success');

        return redirect(session('previous_url')??route('provinces.index'));
    }

    public function destroy(ProvinceDeleteRequest $request,Province $province)
    {
        $province->delete();

        toast(__('message.deleted'), 'success');

        return redirect(session('previous_url')??route('provinces.index'));
    }

    public function search(Request $request): \Illuminate\Http\JsonResponse
    {
        $query = Province::query();

        if ($request->filled('q')) {
            $query->where('name', 'LIKE', '%' . $request->q . '%');
        }

        $provinces = $query->get()->map(function ($province) {
            return [
                'id' => $province->id,
                'title' => $province->name, 
                'subtitle' => $province->country->name ?? '',
                'avatar' => $province->country->flag->address ?? '/images/default-image.png',
            ];
        });

        return response()->json($provinces);
    }
}
