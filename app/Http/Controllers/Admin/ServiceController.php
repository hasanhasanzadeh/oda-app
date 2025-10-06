<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\ServiceAllRequest;
use App\Http\Requests\Service\ServiceCreateFormRequest;
use App\Http\Requests\Service\ServiceCreateRequest;
use App\Http\Requests\Service\ServiceDeleteRequest;
use App\Http\Requests\Service\ServiceEditFormRequest;
use App\Http\Requests\Service\ServiceFindRequest;
use App\Http\Requests\Service\ServiceUpdateRequest;
use App\Models\Service;
use App\Services\ServiceService;

class ServiceController extends Controller
{
    public function __construct(private readonly ServiceService $service)
    {
    }

    public function index(ServiceAllRequest $request)
    {
        $title = __('message.services');
        $validated = $request->validated();
        $services = $this->service->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.service.index', [
            'title' => $title,
            'services' => $services,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }


    public function create(ServiceCreateFormRequest $request)
    {
        $title = __('message.create');

        return view('admin.service.create', compact(['title']));
    }

    public function store(ServiceCreateRequest $request)
    {
        $service = $this->service->create( $request->validated());
        if ($service) {
            toast(__('message.created'), 'success');
        }else{
            toast(__('message.contCreate'), 'error');
        }

        return redirect(session('previous_url')??route('services.index'));
    }


    public function show(ServiceFindRequest $request, Service $service)
    {
        $title = __('message.show');

        return view('admin.service.show', compact(['title', 'service']));
    }


    public function edit(ServiceEditFormRequest $request, Service $service)
    {
        $title = __('message.edit');

        return view('admin.service.edit', compact(['title', 'service']));
    }


    public function update(ServiceUpdateRequest $request, Service $service)
    {
        $service = $this->service->update( $service->id,$request->validated());
        if ($service) {
            toast(__('message.updated'), 'success');
        }else{
            toast(__('message.contUpdate'), 'error');
        }

        return redirect(session('previous_url')??route('services.index'));
    }

    public function destroy(ServiceDeleteRequest $request, Service $service)
    {
        $service = $this->service->delete( $service->id);
        if ($service) {
            toast(__('message.deleted'), 'success');
        }else{
            toast(__('message.contDelete'), 'error');
        }

        return redirect(session('previous_url')??route('services.index'));
    }

}
