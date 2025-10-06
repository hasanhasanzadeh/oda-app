<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryAllRequest;
use App\Http\Requests\Category\CategoryCreateFormRequest;
use App\Http\Requests\Category\CategoryCreateRequest;
use App\Http\Requests\Category\CategoryDeleteRequest;
use App\Http\Requests\Category\CategoryFindRequest;
use App\Http\Requests\Category\CategoryUpdateFormRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(readonly private CategoryService $categoryService)
    {
    }

    public function index(CategoryAllRequest $request)
    {
        $title = __('message.categories');
        $validated = $request->validated();
        $categories = $this->categoryService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.category.index', [
            'categories'=>$categories,
            'title'=>$title,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }

    public function create(CategoryCreateFormRequest $request)
    {
        $title = __('message.create');

        return view('admin.category.create', compact(['title']));
    }

    public function store(CategoryCreateRequest $request): RedirectResponse
    {
        $parent_id=$request->parent_id??0;
        $category = new Category();
        $category->name = $request->name;
        $category->parent_id = $parent_id;
        $category->status = $request->status;
        $category->slug = Helper::slugMake($request->slug);
        $category->save();
        $category->meta()->create([
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description
        ]);
        if ($request->file('image')) {
            $path = str_replace('public', 'storage', $request->file('image')->store('public/categories'));
            $category->photo()->create(['path' => $path]);
        }
        toast(__('message.created'), 'success');
        return redirect(session('previous_url')??route('categories.index'));
    }

    public function show(CategoryFindRequest $request, Category $category)
    {
        $title = __('message.show');

        return view('admin.category.show', compact(['category', 'title']));
    }

    public function edit(CategoryUpdateFormRequest $request, Category $category)
    {
        $title = __('message.edit');

        $categories = Category::with('photo')->get();


        return view('admin.category.edit', compact(['category', 'title', 'categories']));
    }


    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $parent_id=$request->parent_id;
        if ($parent_id!=0){
            $cat=Category::find($parent_id);
            if ($request->parent_id==$category->id || $request->parent_id==null || $request->parent_id=='NULL' || $category->id==$cat->parent_id){
                $parent_id=$category->parent_id;
            }
        }
        if ($request->parent_id == null) {
            $parent_id = 0;
        }
        $category->name = $request->name;
        $category->parent_id = $parent_id;
        $category->status = $request->status;
        $category->slug = Helper::slugMake($request->slug);;
        $category->save();
        if ($request->image) {
            if ($category->photo) {
                Helper::deleteFile($category->photo->url);
                $category->photo()->delete();
            }
            $path = str_replace('public', 'storage', $request->file('image')->store('public/categories'));
            $category->photo()->create(['path' => $path]);
        }
        $category->meta()->update([
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description
        ]);
        toast(__('message.updated'), 'success');

        return redirect(session('previous_url')??route('categories.index'));
    }

    public function destroy(CategoryDeleteRequest $request, Category $category): RedirectResponse
    {
        $category->delete();
        toast(__('message.deleted'), 'success');

        return redirect(session('previous_url')??route('categories.index'));

    }

    public function search(Request $request): \Illuminate\Http\JsonResponse
    {
        $query = Category::query();

        if ($request->filled('q')) {
            $query->where('name', 'LIKE', '%' . $request->q . '%');
        }

        $categories = $query->take(20)->get()->map(function ($category) {
            return [
                'id' => $category->id,
                'title' => $category->name,
                'subtitle' => $category->name ?? '',
                'avatar' => $category->photo->address ?? '/images/default-image.png',
            ];
        });

        return response()->json($categories);
    }
}
