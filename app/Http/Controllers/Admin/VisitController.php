<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Visit\VisitAllRequest;
use App\Http\Requests\Visit\VisitDeleteRequest;
use App\Services\VisitService;
use Illuminate\Support\Facades\DB;

class VisitController extends Controller
{
    public function __construct(readonly private VisitService $visitService
    )
    {
    }

    public function index(VisitAllRequest $visitAllRequest)
    {
        $validated = $visitAllRequest->validated();
        $visits = $this->visitService->all($validated);
        $title = 'بازدید ها';
        session(['previous_url' => url()->full()]);
        return view('admin.visit.index', [
            'visits' => $visits,
            'title' => $title,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }

    public function destroy(VisitDeleteRequest $visitDeleteRequest, $id)
    {
        $this->visitService->delete($id);
        toast('اطلاعات بازدید مورد باموفقیت حذف شد', 'success');
        return redirect(session('previous_url')??route('visits.index'));
    }

    public function deleteAll(VisitDeleteRequest $visitDeleteRequest)
    {
        DB::table('visits')->truncate();
        toast('تمامی اطلاعات بازدید ها با موفقیت حذف شد', 'success');
        return redirect(session('previous_url')??route('visits.index'));
    }
}
