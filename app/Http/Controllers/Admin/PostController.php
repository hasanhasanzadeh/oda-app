<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostAllRequest;
use App\Http\Requests\Post\PostCreateFormRequest;
use App\Http\Requests\Post\PostCreateRequest;
use App\Http\Requests\Post\PostDeleteRequest;
use App\Http\Requests\Post\PostFindRequest;
use App\Http\Requests\Post\PostUpdateFormRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Models\Order;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(private readonly PostService $postService)
    {
    }

    public function index(PostAllRequest $request)
    {
        $title = __('message.posts');
        $validated = $request->validated();
        $posts = $this->postService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.post.index', [
            'title' => $title,
            'posts' => $posts,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }


    public function create(PostCreateFormRequest $request)
    {
        $title = __('message.create');

        return view('admin.post.create', compact([ 'title']));
    }

    public function store(PostCreateRequest $request)
    {
        $post = $this->postService->create($request->validated());
        if (!$post) {
            toast(__('message.server_error'), 'error');
        }
        toast(__('message.created'), 'success');
        return redirect(session('previous_url')??route('posts.index'));
    }


    public function show(PostFindRequest $request,Post $post)
    {
        $title = __('message.show');

        return view('admin.post.show', compact([ 'title', 'post']));
    }


    public function edit(PostUpdateFormRequest $request,Post $post)
    {
        $title = __('message.edit');

        return view('admin.post.edit', compact(['title', 'post']));
    }


    public function update(PostUpdateRequest $request, Post $post)
    {
        $post = $this->postService->update($post->id,$request->validated());
        if (!$post) {
            toast(__('message.server_error'), 'error');
        }

        toast(__('message.updated'), 'success');

        return redirect(session('previous_url')??route('posts.index'));
    }

    public function destroy(PostDeleteRequest $request,Post $post)
    {
        $order = Order::where('post_id', $post->id)->first();

        if ($order) {
            toast(__('message.warning'), 'success');
            return redirect(session('previous_url') ?? route('posts.index'));
        }

        $post->delete();

        toast(__('message.deleted'), 'success');
        return redirect(session('previous_url') ?? route('posts.index'));
    }

}
