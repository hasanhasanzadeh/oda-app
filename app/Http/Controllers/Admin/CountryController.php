<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Country\CountryAllRequest;
use App\Http\Requests\Country\CountryCreateFormRequest;
use App\Http\Requests\Country\CountryCreateRequest;
use App\Http\Requests\Country\CountryDeleteRequest;
use App\Http\Requests\Country\CountryFindRequest;
use App\Http\Requests\Country\CountryUpdateFormRequest;
use App\Http\Requests\Country\CountryUpdateRequest;
use App\Models\Country;
use App\Models\Province;
use App\Services\CountryService;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct(private readonly CountryService $countryService)
    {
    }

    public function index(CountryAllRequest $request)
    {
        $title = __('message.countries');
        $validated = $request->validated();
        $countries = $this->countryService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.country.index', [
            'title' => $title,
            'countries' => $countries,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }


    public function create(CountryCreateFormRequest $request)
    {
        $title = __('message.create');

        return view('admin.country.create', compact([ 'title']));
    }

    public function store(CountryCreateRequest $request)
    {
        $country = $this->countryService->create($request->validated());
        if (!$country) {
            toast(__('message.server_error'), 'error');
        }
        toast(__('message.created'), 'success');
        return redirect(session('previous_url')??route('countries.index'));
    }


    public function show(CountryFindRequest $request,Country $country)
    {
        $title = __('message.show');

        return view('admin.country.show', compact([ 'title', 'country']));
    }


    public function edit(CountryUpdateFormRequest $request,Country $country)
    {
        $title = __('message.edit');

        return view('admin.country.edit', compact(['title', 'country']));
    }


    public function update(CountryUpdateRequest $request, Country $country)
    {
        $country = $this->countryService->update($country->id,$request->validated());
        if (!$country) {
            toast(__('message.server_error'), 'error');
        }

        toast(__('message.updated'), 'success');

        return redirect(session('previous_url')??route('countries.index'));
    }

    public function destroy(CountryDeleteRequest $request,Country $country)
    {
        $province = Province::where('country_id', $country->id)->first();

        if ($province) {
            toast(__('message.warning'), 'success');
            return redirect(session('previous_url')??route('countries.index'));
        }

        $country->delete();

        toast(__('message.deleted'), 'success');
        return redirect(session('previous_url')??route('countries.index'));
    }
    public function search(Request $request): \Illuminate\Http\JsonResponse
    {
        $query = Country::query();

        if ($request->filled('q')) {
            $query->where('country_name', 'LIKE', '%' . $request->q . '%')
                ->orWhere('country_persian_name', 'LIKE', '%' . $request->q . '%');
        }

        $countries = $query->get()->map(function ($country) {
            return [
                'id' => $country->id,
                'title' => $country->country_persian_name,
                'subtitle' => $country->country_name ?? '',
                'avatar' => $country->flag->address ?? '/images/default-image.png',
            ];
        });

        return response()->json($countries);
    }

}
