<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Room\RoomAllRequest;
use App\Http\Requests\Room\RoomCreateFormRequest;
use App\Http\Requests\Room\RoomCreateRequest;
use App\Http\Requests\Room\RoomDeleteRequest;
use App\Http\Requests\Room\RoomFindRequest;
use App\Http\Requests\Room\RoomUpdateFormRequest;
use App\Http\Requests\Room\RoomUpdateRequest;
use App\Models\Room;
use App\Services\RoomService;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function __construct(private readonly RoomService $roomService)
    {
    }

    public function index(RoomAllRequest $request)
    {
        $title = __('message.rooms');
        $validated = $request->validated();
        $rooms = $this->roomService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.room.index', [
            'title' => $title,
            'rooms' => $rooms,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }


    public function create(RoomCreateFormRequest $request)
    {
        $title = __('message.create');

        return view('admin.room.create', compact([ 'title']));
    }

    public function store(RoomCreateRequest $request)
    {
        $room = $this->roomService->create($request->validated());
        if (!$room) {
            toast(__('message.server_error'), 'error');
        }
        toast(__('message.created'), 'success');
        return redirect(session('previous_url')??route('rooms.index'));
    }


    public function show(RoomFindRequest $request,Room $room)
    {
        $title = __('message.show');

        return view('admin.room.show', compact([ 'title', 'room']));
    }


    public function edit(RoomUpdateFormRequest $request,Room $room)
    {
        $title = __('message.edit');

        return view('admin.room.edit', compact(['title', 'room']));
    }


    public function update(RoomUpdateRequest $request, Room $room)
    {
        $room = $this->roomService->update($room->id,$request->validated());
        if (!$room) {
            toast(__('message.server_error'), 'error');
        }

        toast(__('message.updated'), 'success');

        return redirect(session('previous_url')??route('rooms.index'));
    }

    public function destroy(RoomDeleteRequest $request,Room $room)
    {
        $room = $this->roomService->delete($room->id);

        toast(__('message.deleted'), 'success');
        return redirect(session('previous_url')??route('rooms.index'));
    }

    public function search(Request $request)
    {
        $rooms = [];
        if ($request->has('q')) {
            $search = $request->q;
            $rooms = Room::select("id", "room_persian_name")
                ->where('room_persian_name', 'LIKE', "%$search%")
                ->get();
        }

        $rooms = collect($rooms);

        return response()->json($rooms);
    }
}
