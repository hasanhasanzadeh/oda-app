<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Group\GroupAllRequest;
use App\Http\Requests\Group\GroupCreateFormRequest;
use App\Http\Requests\Group\GroupCreateRequest;
use App\Http\Requests\Group\GroupDeleteRequest;
use App\Http\Requests\Group\GroupFindRequest;
use App\Http\Requests\Group\GroupUpdateFormRequest;
use App\Http\Requests\Group\GroupUpdateRequest;
use App\Models\Group;
use App\Services\GroupService;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function __construct(private readonly GroupService $groupService)
    {
    }

    public function index(GroupAllRequest $request)
    {
        $title = __('message.groups');
        $validated = $request->validated();
        $groups = $this->groupService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.group.index', [
            'title' => $title,
            'groups' => $groups,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }


    public function create(GroupCreateFormRequest $request)
    {
        $title = __('message.create');

        return view('admin.group.create', compact([ 'title']));
    }

    public function store(GroupCreateRequest $request)
    {
        $group = $this->groupService->create($request->validated());
        if (!$group) {
            toast(__('message.server_error'), 'error');
        }
        toast(__('message.created'), 'success');
        return redirect(session('previous_url')??route('groups.index'));
    }


    public function show(GroupFindRequest $request,Group $group)
    {
        $title = __('message.show');

        return view('admin.group.show', compact([ 'title', 'group']));
    }


    public function edit(GroupUpdateFormRequest $request,Group $group)
    {
        $title = __('message.edit');

        return view('admin.group.edit', compact(['title', 'group']));
    }


    public function update(GroupUpdateRequest $request, Group $group)
    {
        $group = $this->groupService->update($group->id,$request->validated());
        if (!$group) {
            toast(__('message.server_error'), 'error');
        }

        toast(__('message.updated'), 'success');

        return redirect(session('previous_url')??route('groups.index'));
    }

    public function destroy(GroupDeleteRequest $request,Group $group)
    {
        $group = $this->groupService->delete($group->id);
        toast(__('message.deleted'), 'success');
        return redirect(session('previous_url')??route('groups.index'));
    }

    public function search(Request $request)
    {
        $groups = [];
        if ($request->has('q')) {
            $search = $request->q;
            $groups = Group::select("id", "group_persian_name")
                ->where('group_persian_name', 'LIKE', "%$search%")
                ->get();
        }

        $groups = collect($groups);

        return response()->json($groups);
    }
}
