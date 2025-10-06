<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Symbol\SymbolAllRequest;
use App\Http\Requests\Symbol\SymbolCreateFormRequest;
use App\Http\Requests\Symbol\SymbolCreateRequest;
use App\Http\Requests\Symbol\SymbolDeleteRequest;
use App\Http\Requests\Symbol\SymbolEditFormRequest;
use App\Http\Requests\Symbol\SymbolFindRequest;
use App\Http\Requests\Symbol\SymbolUpdateRequest;
use App\Models\Setting;
use App\Models\Symbol;
use App\Models\User;
use App\Services\SettingService;
use App\Services\SymbolService;

class SymbolController extends Controller
{
    public function __construct(readonly private SymbolService $symbolService)
    {
    }

    public function index(SymbolAllRequest $request)
    {
        $title = __('message.symbols');
        $validated = $request->validated();
        $symbols = $this->symbolService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.symbol.index', [
            'title' => $title,
            'symbols' => $symbols,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }

    public function create(SymbolCreateFormRequest $request)
    {
        $title = __('message.symbol');

        return view('admin.symbol.create', compact(['title']));
    }

    public function store(SymbolCreateRequest $request)
    {
        $symbol = new Symbol();
        $symbol->setting_id = $request->setting_id;
        $symbol->title = $request->title;
        $symbol->link = $request->link;
        $symbol->description = $request->description;
        $symbol->status = $request->status;
        $symbol->save();

        if ($request->file('image')) {
            $path = str_replace('public', 'storage', $request->file('image')->store('public/symbols'));
            $symbol->photo()->create(['path' => $path]);
        }

        toast(__('message.created'), 'success');

        return redirect(session('previous_url')??route('symbols.index'));

    }

    public function show(SymbolFindRequest $request, Symbol $symbol)
    {
        $title = __('message.show');

        return view('admin.symbol.show', compact(['symbol', 'title']));
    }


    public function edit(SymbolEditFormRequest $request, Symbol $symbol)
    {
        $title = __('message.show');

        return view('admin.symbol.edit', compact(['symbol', 'title']));
    }


    public function update(SymbolUpdateRequest $request, Symbol $symbol)
    {
        $symbol->setting_id = $request->setting_id;
        $symbol->title = $request->title;
        $symbol->link = $request->link;
        $symbol->status = $request->status;
        $symbol->description = $request->description;
        $symbol->save();
        if ($request->file('image')) {
            if ($symbol->photo) {
                Helper::deleteFile($symbol->photo->url);
                $symbol->photo()->delete();
            }

            $path = str_replace('public', 'storage', $request->file('image')->store('public/symbols'));
            $symbol->photo()->create(['path' => $path]);
        }
        toast(__('message.updated'), 'success');

        return redirect(session('previous_url')??route('symbols.index'));
    }

    public function destroy(SymbolDeleteRequest $request, Symbol $symbol)
    {
        $symbol->delete();

        toast(__('message.deleted'), 'success');
        return redirect(session('previous_url')??route('symbols.index'));
    }
}
