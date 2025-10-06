<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Level\LevelAllRequest;
use App\Http\Requests\Level\LevelCreateFormRequest;
use App\Http\Requests\Level\LevelCreateRequest;
use App\Http\Requests\Level\LevelDeleteRequest;
use App\Http\Requests\Level\LevelFindRequest;
use App\Http\Requests\Level\LevelUpdateFormRequest;
use App\Http\Requests\Level\LevelUpdateRequest;
use App\Models\Level;
use App\Services\LevelService;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function __construct(private readonly LevelService $levelService)
    {
    }

    public function index(LevelAllRequest $request)
    {
        $title = __('message.levels');
        $validated = $request->validated();
        $levels = $this->levelService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.level.index', [
            'title' => $title,
            'levels' => $levels,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }


    public function create(LevelCreateFormRequest $request)
    {
        $title = __('message.create');

        return view('admin.level.create', compact([ 'title']));
    }

    public function store(LevelCreateRequest $request)
    {
        $level = $this->levelService->create($request->validated());
        if (!$level) {
            toast(__('message.server_error'), 'error');
        }
        toast(__('message.created'), 'success');
        return redirect(session('previous_url')??route('levels.index'));
    }


    public function show(LevelFindRequest $request,Level $level)
    {
        $title = __('message.show');

        return view('admin.level.show', compact([ 'title', 'level']));
    }


    public function edit(LevelUpdateFormRequest $request,Level $level)
    {
        $title = __('message.edit');

        return view('admin.level.edit', compact(['title', 'level']));
    }


    public function update(LevelUpdateRequest $request, Level $level)
    {
        $level = $this->levelService->update($level->id,$request->validated());
        if (!$level) {
            toast(__('message.server_error'), 'error');
        }

        toast(__('message.updated'), 'success');

        return redirect(session('previous_url')??route('levels.index'));
    }

    public function destroy(LevelDeleteRequest $request,Level $level)
    {
        $level = $this->levelService->delete($level->id);
        toast(__('message.deleted'), 'success');
        return redirect(session('previous_url')??route('levels.index'));
    }

    public function search(Request $request)
    {
        $levels = [];
        if ($request->has('q')) {
            $search = $request->q;
            $levels = Level::select("id", "level_persian_name")
                ->where('level_persian_name', 'LIKE', "%$search%")
                ->get();
        }

        $levels = collect($levels);

        return response()->json($levels);
    }
}
