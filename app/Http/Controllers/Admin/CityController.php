<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\City\CityAllRequest;
use App\Http\Requests\City\CityCreateFormRequest;
use App\Http\Requests\City\CityCreateRequest;
use App\Http\Requests\City\CityDeleteRequest;
use App\Http\Requests\City\CityFindRequest;
use App\Http\Requests\City\CityUpdateFormRequest;
use App\Http\Requests\City\CityUpdateRequest;
use App\Models\City;
use App\Models\Setting;
use App\Models\User;
use App\Services\CityService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CityController extends Controller
{

    public function __construct(private readonly CityService $cityService)
    {
    }

    public function index(CityAllRequest $request): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $title = __('message.cities');
        $validated = $request->validated();
        $cities = $this->cityService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.city.index', [
            'title' => $title,
            'cities' => $cities,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }


    public function create(CityCreateFormRequest $request): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $title = __('message.create');

        return view('admin.city.create', compact(['title']));
    }

    public function store(CityCreateRequest $request): RedirectResponse
    {
        $city = new City();
        $city->name = $request->city_name;
        $city->province_id = $request->province_id;
        $city->save();

        toast(__('message.created'), 'success');
        return redirect(session('previous_url')??route('cities.index'));
    }


    public function show(CityFindRequest $request,City $city): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $title = __('message.show');

        return view('admin.city.show', compact([ 'title', 'city']));
    }


    public function edit(CityUpdateFormRequest $request,City $city): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $title = __('message.edit');

        return view('admin.city.edit', compact([ 'title', 'city']));
    }


    public function update(CityUpdateRequest $request, City $city): RedirectResponse
    {
        $city->name = $request->city_name;
        $city->province_id = $request->province_id;
        $city->save();

        toast(__('message.created'), 'success');

        return redirect(session('previous_url')??route('cities.index'));
    }

    public function destroy(CityDeleteRequest $request,City $city): RedirectResponse
    {
        $city->delete();
        toast(__('message.deleted'), 'success');

        return redirect(session('previous_url')??route('cities.index'));
    }

    public function search(Request $request): \Illuminate\Http\JsonResponse
    {
        $query = City::query();

        if ($request->filled('q')) {
            $query->where('name', 'LIKE', '%' . $request->q . '%');
        }

        $cities = $query->get()->map(function ($city) {
            return [
                'id' => $city->id,
                'title' => $city->name,
                'subtitle' => $city->province?->name.'-'.$city->province->country?->country_persian_name ?? '',
                'avatar' => $city->province->country->flag->address ?? '/images/default-image.png',
            ];
        });

        return response()->json($cities);
    }
}
