<?php
namespace App\Repositories;

use App\Helpers\Helper;
use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PostRepository implements PostRepositoryInterface
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
        $allowedColumns = ['name', 'id', 'sku', 'created_at'];
        if (!in_array($column, $allowedColumns)) {
            $column = 'created_at';
        }
        $posts = Post::query();

        if ($keyword =  request('search')) {
            $posts->where('name', 'LIKE', "%{$keyword}%");
        }
        if (request()->has('status')) {
            $status = filter_var(request('status'), FILTER_VALIDATE_BOOLEAN);
            $posts->where('status', $status);
        }
        if (!empty($filters['from_date']) || !empty($filters['to_date'])) {
            $from_date = $filters['from_date'] ?? null;
            $to_date = $filters['to_date'] ?? null;

            $posts = $posts->when($from_date, fn($q) => $q->whereDate('created_at', '>=', $from_date))
                ->when($to_date, fn($q) => $q->whereDate('created_at', '<=', $to_date));
        }
        return $posts->with(['photo'])->orderBy($column, $direction === 'asc' ? 'asc' : 'desc')->paginate($perPage);
    }

    public function find($id)
    {
        return Post::findOrFail($id);
    }
    public function create(array $data)
    {
        DB::transaction(function () use ($data) {
            $data['photo_id'] = Helper::uploadImage($data['image']);
            $post = Post::create($data);
            return $post;
        });

    }

    public function update($id, array $data)
    {
        DB::transaction(function () use ($id, $data) {
            $post = Post::findOrFail($id);
            if (isset($data['image'])){
                if ($post->photo){
                    Helper::deleteFile($post->photo->url);
                    $post->photo()->delete();
                }
                $data['photo_id'] = Helper::uploadImage($data['image']->file('image'));
            }
            $post->update($data);
            return $post;
        });
    }

    public function delete($id)
    {
        DB::transaction(function () use ($id) {
            $post = Post::findOrFail($id);
            if ($post->photo) {
                Helper::deleteFile($post->photo->url);
                $post->photo()->delete();
            }
            return $post->delete();
        });
    }
}
