<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\BlogAllRequest;
use App\Http\Requests\Blog\BlogCreateFormRequest;
use App\Http\Requests\Blog\BlogCreateRequest;
use App\Http\Requests\Blog\BlogDeleteRequest;
use App\Http\Requests\Blog\BlogFindRequest;
use App\Http\Requests\Blog\BlogUpdateFormRequest;
use App\Http\Requests\Blog\BlogUpdateRequest;
use App\Models\Blog;
use App\Services\BlogService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{

    public function __construct(readonly private BlogService $blogService)
    {
    }

    public function index(BlogAllRequest $request)
    {
        $title = __('message.blogs');
        $validated = $request->validated();
        $blogs = $this->blogService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.blog.index', [
            'title' => $title,
            'blogs' => $blogs,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }


    public function create(BlogCreateFormRequest $request)
    {
        $title = __('message.create');

        return view('admin.blog.create', compact(['title']));
    }

    public function store(BlogCreateRequest $request): RedirectResponse
    {
        $video_id = null;
        if ($request->file('video')) {
            $video_id = Helper::uploadVideo($request->file('video'));
        }
        $blog = new Blog();
        $blog->title = $request->title;
        $blog->slug = Helper::slugMake($request->slug);
        $blog->description = $request->description;
        $blog->video_id = $video_id;
        $blog->status = $request->status;
        $blog->author_id = auth()->user()->id;
        $blog->publish_date = $request->publish_date ?? Carbon::now()->format('Y-m-d');
        $blog->save();
        $blog->meta()->create([
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description
        ]);
        if ($request->tags) {
            foreach ($request->tags as $tag) {
                $blog->tags()->firstOrCreate(['name' => $tag, 'slug' => Helper::slugMake($tag)]);
            }
        }
        if ($request->file('image')) {
            $path = str_replace('public', 'storage', $request->file('image')->store('public/blogs'));
            $blog->photo()->create(['path' => $path]);
        }
        toast(__('message.created'), 'success');
        return redirect(session('previous_url')??route('blogs.index'));
    }


    public function show(BlogFindRequest $request, Blog $blog)
    {
        $title = __('message.show');
        $blog->load([ 'author', 'video', 'photo']);
        return view('admin.blog.show', compact(['title', 'blog']));
    }


    public function edit(BlogUpdateFormRequest $request, Blog $blog)
    {
        $title = __('message.edit');
        $blog->load([ 'author', 'video', 'photo']);

        return view('admin.blog.edit', compact(['title', 'blog']));
    }


    public function update(BlogUpdateRequest $request, Blog $blog): RedirectResponse
    {
        $video_id = null;
        if ($request->hasFile('video')) {
            if ($blog->video) {
                Storage::disk('public')->delete($blog->video->url);
                $blog->video()->delete();
            }
            $video_id = Helper::uploadVideo($request->file('video'));
        }
        if ($request->publish_date) {
            $blog->publish_date = $request->publish_date;
        }
        $blog->title = $request->title;
        $blog->slug = Helper::slugMake($request->slug);
        $blog->description = $request->description;
        $blog->status = $request->status;
        $blog->video_id = $video_id;
        $blog->author_id = auth()->user()->id;
        $blog->save();
        if (empty($blog->meta)) {
            $blog->meta()->create([
                'meta_title' => $request->meta_title,
                'meta_keywords' => $request->meta_keywords,
                'meta_description' => $request->meta_description
            ]);
        } else {
            $blog->meta()->update([
                'meta_title' => $request->meta_title,
                'meta_keywords' => $request->meta_keywords,
                'meta_description' => $request->meta_description
            ]);
        }
        if ($request->tags) {
            $blog->tags()->delete();
            foreach ($request->tags as $tag) {
                $blog->tags()->firstOrCreate(['name' => $tag, 'slug' => Helper::slugMake($tag)]);
            }
        }
        if ($request->file('image')) {
            if ($blog->photo) {
                Helper::deleteFile($blog->photo->url);
                $blog->photo()->delete();
            }
            $path = str_replace('public', 'storage', $request->file('image')->store('public/blogs'));
            $blog->photo()->create(['path' => $path]);
        }
        toast(__('message.updated'), 'success');

        return redirect(session('previous_url')??route('blogs.index'));

    }

    public function destroy(BlogDeleteRequest $request, Blog $blog): RedirectResponse
    {
        DB::transaction(function () use ($request, $blog) {
            Helper::deleteFile($blog->photo->url);
            if ($blog->video_id) {
                Helper::deleteFile($blog->video->url);
            }
            $blog->delete();
        });

        toast(__('message.deleted'), 'success');

        return redirect(session('previous_url')??route('blogs.index'));
    }
}
