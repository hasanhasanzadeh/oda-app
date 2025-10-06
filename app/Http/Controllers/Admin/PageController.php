<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Page\PageAllRequest;
use App\Http\Requests\Page\PageCreateFormRequest;
use App\Http\Requests\Page\PageCreateRequest;
use App\Http\Requests\Page\PageDeleteRequest;
use App\Http\Requests\Page\PageFindRequest;
use App\Http\Requests\Page\PageUpdateFormRequest;
use App\Http\Requests\Page\PageUpdateRequest;
use App\Models\Page;
use App\Models\Setting;
use App\Models\User;
use App\Services\PageService;
use App\Services\SettingService;

class PageController extends Controller
{

    public function __construct(readonly private PageService $pageService)
    {
    }

    public function index(PageAllRequest $request)
    {
        $title = __('message.pages');
        $validated = $request->validated();
        $pages = $this->pageService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.page.index', [
            'title' => $title,
            'pages' => $pages,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }

    public function create(PageCreateFormRequest $request)
    {
        $title = __('message.create');

        return view('admin.page.create', compact(['title']));
    }

    public function store(PageCreateRequest $request)
    {
        $page = new Page();
        $page->title = $request->title;
        $page->slug = Helper::slugMake($request->slug);
        $page->description = $request->description;
        $page->status = $request->status;
        $page->save();
        $page->meta()->create([
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description
        ]);
        if ($request->file('image')) {
            $path = str_replace('public', 'storage', $request->file('image')->store('public/pages'));
            $page->photo()->create(['path' => $path]);
        }

        toast(__('message.created'), 'success');

        return redirect(session('previous_url')??route('pages.index'));
    }

    public function show(PageFindRequest $request, Page $page)
    {
        $title = __('message.show');

        return view('admin.page.show', compact(['page', 'title']));
    }

    public function edit(PageUpdateFormRequest $request, Page $page)
    {
        $title = __('message.edit');

        return view('admin.page.edit', compact(['page', 'title']));
    }

    public function update(PageUpdateRequest $request, Page $page)
    {
        $page->title = $request->title;
        $page->slug = Helper::slugMake($request->slug);
        $page->description = $request->description;
        $page->status = $request->status;
        $page->save();
        $page->meta()->update([
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description
        ]);
        if ($request->image) {
            if ($page->photo) {
                Helper::deleteFile($page->photo->url);
                $page->photo()->delete();
            }
            $path = str_replace('public', 'storage', $request->file('image')->store('public/pages'));
            $page->photo()->create(['path' => $path]);
        }

        toast(__('message.updated'), 'success');

        return redirect(session('previous_url')??route('pages.index'));
    }

    public function destroy(PageDeleteRequest $request, Page $page)
    {
        $page->photo()->delete();
        $page->delete();

        toast(__('message.deleted'), 'success');

        return redirect(session('previous_url')??route('pages.index'));
    }
}
