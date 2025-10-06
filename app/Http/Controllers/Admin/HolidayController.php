<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bholiday\HolidayUpdateFormRequest;
use App\Http\Requests\Holiday\HolidayAllRequest;
use App\Http\Requests\Holiday\HolidayCreateFormRequest;
use App\Http\Requests\Holiday\HolidayCreateRequest;
use App\Http\Requests\Holiday\HolidayDeleteRequest;
use App\Http\Requests\Holiday\HolidayFindRequest;
use App\Http\Requests\Holiday\HolidayUpdateRequest;
use App\Models\Holiday;
use App\Services\HolidayService;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    public function __construct(private readonly HolidayService $holidayService)
    {
    }

    public function index(HolidayAllRequest $request)
    {
        $title = __('message.holidays');
        $validated = $request->validated();
        $holidays = $this->holidayService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.holiday.index', [
            'title' => $title,
            'holidays' => $holidays,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }


    public function create(HolidayCreateFormRequest $request)
    {
        $title = __('message.create');

        return view('admin.holiday.create', compact([ 'title']));
    }

    public function store(HolidayCreateRequest $request)
    {
        $holiday = $this->holidayService->create($request->validated());
        if (!$holiday) {
            toast(__('message.server_error'), 'error');
        }
        toast(__('message.created'), 'success');
        return redirect(session('previous_url')??route('holidays.index'));
    }


    public function show(HolidayFindRequest $request,Holiday $holiday)
    {
        $title = __('message.show');

        return view('admin.holiday.show', compact([ 'title', 'holiday']));
    }


    public function edit(HolidayUpdateFormRequest $request,Holiday $holiday)
    {
        $title = __('message.edit');

        return view('admin.holiday.edit', compact(['title', 'holiday']));
    }


    public function update(HolidayUpdateRequest $request, Holiday $holiday)
    {
        $holiday = $this->holidayService->update($holiday->id,$request->validated());
        if (!$holiday) {
            toast(__('message.server_error'), 'error');
        }

        toast(__('message.updated'), 'success');

        return redirect(session('previous_url')??route('holidays.index'));
    }

    public function destroy(HolidayDeleteRequest $request,Holiday $holiday)
    {
        $holiday = $this->holidayService->delete($holiday->id);
        toast(__('message.deleted'), 'success');
        return redirect(session('previous_url')??route('holidays.index'));
    }

    public function search(Request $request)
    {
        $holidays = [];
        if ($request->has('q')) {
            $search = $request->q;
            $holidays = Holiday::select("id", "holiday_persian_name")
                ->where('holiday_persian_name', 'LIKE', "%$search%")
                ->get();
        }

        $holidays = collect($holidays);

        return response()->json($holidays);
    }
}
