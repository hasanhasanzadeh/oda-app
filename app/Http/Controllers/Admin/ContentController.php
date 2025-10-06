<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Content\ContentAllRequest;
use App\Http\Requests\Content\ContentCreateFormRequest;
use App\Http\Requests\Content\ContentCreateRequest;
use App\Http\Requests\Content\ContentDeleteRequest;
use App\Http\Requests\Content\ContentUpdateFormRequest;
use App\Http\Requests\Content\ContentFindRequest;
use App\Http\Requests\Content\ContentUpdateRequest;
use App\Models\Content;
use App\Services\ContentService;

class ContentController extends Controller
{
    public function __construct(private readonly ContentService $contentService)
    {
    }

    public function index(ContentAllRequest $request)
    {
        $title = __('message.contents');
        $validated = $request->validated();
        $contents = $this->contentService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.content.index', [
            'title' => $title,
            'contents' => $contents,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }


    public function create(ContentCreateFormRequest $request)
    {
        $title = __('message.create');

        return view('admin.content.create', compact(['title']));
    }

    public function store(ContentCreateRequest $request)
    {
        $service = $this->contentService->create( $request->validated());
        if ($service) {
            toast(__('message.created'), 'success');
        }else{
            toast(__('message.contCreate'), 'error');
        }

        return redirect(session('previous_url')??route('contents.index'));
    }


    public function show(ContentFindRequest $request, Content $content)
    {
        $title = __('message.show');

        return view('admin.content.show', compact(['title', 'content']));
    }


    public function edit(ContentUpdateFormRequest $request, Content $content)
    {
        $title = __('message.edit');

        return view('admin.content.edit', compact(['title', 'content']));
    }


    public function update(ContentUpdateRequest $request, Content $content)
    {
        $content = $this->contentService->update( $content->id,$request->validated());
        if ($content) {
            toast(__('message.updated'), 'success');
        }else{
            toast(__('message.contUpdate'), 'error');
        }

        return redirect(session('previous_url')??route('contents.index'));
    }

    public function destroy(ContentDeleteRequest $request, Content $content)
    {
        $content = $this->contentService->delete( $content->id);
        if ($content) {
            toast(__('message.deleted'), 'success');
        }else{
            toast(__('message.contDelete'), 'error');
        }

        return redirect(session('previous_url')??route('contents.index'));
    }

}
