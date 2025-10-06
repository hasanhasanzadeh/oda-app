<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mark\MarkAllRequest;
use App\Http\Requests\Mark\MarkCreateFormRequest;
use App\Http\Requests\Mark\MarkCreateRequest;
use App\Http\Requests\Mark\MarkDeleteRequest;
use App\Http\Requests\Mark\MarkFindRequest;
use App\Http\Requests\Mark\MarkUpdateFormRequest;
use App\Http\Requests\Mark\MarkUpdateRequest;
use App\Models\Mark;
use App\Services\MarkService;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    public function __construct(private readonly MarkService $markService)
    {
    }

    public function index(MarkAllRequest $request)
    {
        $title = __('message.marks');
        $validated = $request->validated();
        $marks = $this->markService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.mark.index', [
            'title' => $title,
            'marks' => $marks,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }


    public function create(MarkCreateFormRequest $request)
    {
        $title = __('message.create');

        return view('admin.mark.create', compact([ 'title']));
    }

    public function store(MarkCreateRequest $request)
    {
        $mark = $this->markService->create($request->validated());
        if (!$mark) {
            toast(__('message.server_error'), 'error');
        }
        toast(__('message.created'), 'success');
        return redirect(session('previous_url')??route('marks.index'));
    }


    public function show(MarkFindRequest $request,Mark $mark)
    {
        $title = __('message.show');

        return view('admin.mark.show', compact([ 'title', 'mark']));
    }


    public function edit(MarkUpdateFormRequest $request,Mark $mark)
    {
        $title = __('message.edit');

        return view('admin.mark.edit', compact(['title', 'mark']));
    }


    public function update(MarkUpdateRequest $request, Mark $mark)
    {
        $mark = $this->markService->update($mark->id,$request->validated());
        if (!$mark) {
            toast(__('message.server_error'), 'error');
        }

        toast(__('message.updated'), 'success');

        return redirect(session('previous_url')??route('marks.index'));
    }

    public function destroy(MarkDeleteRequest $request,Mark $mark)
    {
        $mark = $this->markService->delete($mark->id);
        toast(__('message.deleted'), 'success');
        return redirect(session('previous_url')??route('marks.index'));
    }

    public function search(Request $request)
    {
        $marks = [];
        if ($request->has('q')) {
            $search = $request->q;
            $marks = Mark::select("id", "mark_persian_name")
                ->where('mark_persian_name', 'LIKE', "%$search%")
                ->get();
        }

        $marks = collect($marks);

        return response()->json($marks);
    }
}
