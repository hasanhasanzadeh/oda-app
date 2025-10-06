<?php
namespace App\Repositories;

use App\Helpers\Helper;
use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all(array $filters = []):LengthAwarePaginator
    {
        $perPage = $filters['per_page']??10;
        $column = $filters['sort']??'created_at';
        $direction = $filters['direction']??'desc';

        $allowedPerPage = [10, 25, 50, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        $allowedColumns = ['id','name', 'created_at'];
        if (!in_array($column, $allowedColumns)) {
            $column = 'created_at';
        }
        $categories = Category::query();

        if ($keyword = request('search')) {
            $categories->where('name', 'LIKE', "%{$keyword}%");
        }
        if (!empty($filters['from_date']) || !empty($filters['to_date'])) {
            $from_date = $filters['from_date'] ?? null;
            $to_date = $filters['to_date'] ?? null;

            $categories = $categories->when($from_date, fn($q) => $q->whereDate('created_at', '>=', $from_date))
                ->when($to_date, fn($q) => $q->whereDate('created_at', '<=', $to_date));
        }
        return $categories->with(['photo','children'])->orderBy($column, $direction === 'asc' ? 'asc' : 'desc')->paginate($perPage);
    }

    public function find($id)
    {
        return Category::findOrFail($id);
    }

    public function findShow($id)
    {
        return Category::with([
            'advertisements' => function ($q) {
                $q->where('status', 'active')
                    ->whereHas('user', function ($userQuery) {
                        $userQuery->where('is_active', 1);
                    });
            },
            'advertisements.user',
            'advertisements.city'
        ])->findOrFail($id);
    }

    public function findBySlug($slug):?Category
    {
        return Category::where('slug', $slug,)->firstOrFail();
    }

    public function create(array $data)
    {
        $category = Category::create($data);
        if (isset($data['image'])) {
            $path = str_replace('public', 'storage', $data['image']->store('public/categories'));
            $category->photo()->create(['path' => $path]);
        }
        return $category;
    }

    public function update($id, array $data)
    {
        $category = Category::findOrFail($id);
        $category->update($data);
        if (isset($data['image'])) {
            if ($category->photo) {
                Helper::deleteFile($category->photo->url);
                $category->photo()->delete();
            }
            $path = str_replace('public', 'storage', $data['image']->store('public/categories'));
            $category->photo()->create(['path' => $path]);
        }
        return $category;
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        if ($category->photo) {
            Helper::deleteFile($category->photo->url);
            $category->photo()->delete();
        }
        return $category->delete();
    }

}
