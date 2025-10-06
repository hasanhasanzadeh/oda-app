<?php
namespace App\Repositories;

use App\Helpers\Helper;
use App\Models\Blog;
use App\Repositories\Interfaces\BlogRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BlogRepository implements BlogRepositoryInterface
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

        $allowedColumns = ['id','title', 'status', 'publish_date', 'created_at'];
        if (!in_array($column, $allowedColumns)) {
            $column = 'created_at';
        }
        $data = Blog::query();

        if ($keyword = request('search')) {
            $data->where('title', 'LIKE', "%{$keyword}%");
        }
        if ($status = request('status')) {
            $data->with('author')->where('status', 'LIKE', "%{$status}%");
        }
        if (!empty($filters['from_date']) || !empty($filters['to_date'])) {
            $from_date = $filters['from_date'] ?? null;
            $to_date = $filters['to_date'] ?? null;

            $data = $data->when($from_date, fn($q) => $q->whereDate('created_at', '>=', $from_date))
                ->when($to_date, fn($q) => $q->whereDate('created_at', '<=', $to_date));
        }
        return $data->with('photo')->orderBy($column, $direction === 'asc' ? 'asc' : 'desc')->paginate($perPage);
    }

    public function getTake(int $number = 6): Collection
    {
        return Blog::with('photo')->latest()->take($number)->get();
    }

    public function find($id)
    {
        return Blog::findOrFail($id);
    }

    public function findBySlug($slug): ?Blog
    {
        $blog =Blog::where([
            ['status', true],
            ['slug', $slug],
        ])->firstOrFail();
        $blog->increment('view_count');
        return $blog;
    }

    /**
     * @throws Exception
     */
    public function create(array $data):Blog
    {
        try {
            return DB::transaction(function () use ($data) {
                $blog = Blog::create($data);
                if (isset($data['image'])) {
                    $path = str_replace('public', 'storage', $data['image']->store('public/blogs'));
                    $blog->photo()->create(['path' => $path]);
                }
                if ($data['tags']) {
                    foreach ($data['tags'] as $tag) {
                        $blog->tags()->firstOrCreate(['name' => $tag, 'slug' => Helper::slugMake($tag)]);
                    }
                }
                if ($data['video']) {
                    $video_id = Helper::uploadVideo($data['video']);
                    $blog->video_id=$video_id;
                    $blog->save();
                }
                $blog->meta()->create([
                    'meta_title' => $data['meta_title'],
                    'meta_keywords' => $data['meta_keywords'],
                    'meta_description' => $data['meta_description']
                ]);
                return $blog;
            });
        } catch (Exception $e) {
            Log::error("Failed to create blog post", [
                'blog' => $data,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }

    }

    /**
     * @throws Exception
     */
    public function update($id, array $data):Blog
    {
        try {
            return DB::transaction(function () use ($data,$id) {
                $blog = Blog::findOrFail($id);
                $blog->update($data);
                if (isset($data['image'])) {
                    if ($blog->photo) {
                        Helper::deleteFile($blog->photo->url);
                        $blog->photo()->delete();
                    }
                    $path = str_replace('public', 'storage', $data['image']->store('public/blogs'));
                    $blog->photo()->create(['path' => $path]);
                }
                if ($data['tags']) {
                    $blog->tags()->delete();
                    foreach ($data['tags'] as $tag) {
                        $blog->tags()->firstOrCreate(['name' => $tag, 'slug' => Helper::slugMake($tag)]);
                    }
                }
                if ($data['video']) {
                    if ($blog->video) {
                        Storage::disk('public')->delete($blog->video->url);
                        $blog->video()->delete();
                    }
                    $video_id = Helper::uploadVideo($data['video']);
                    $blog->video_id=$video_id;
                }
                if (empty($blog->meta)) {
                    $blog->meta()->create([
                        'meta_title' => $data['meta_title'],
                        'meta_keywords' => $data['meta_keywords'],
                        'meta_description' => $data['meta_description']
                    ]);
                } else {
                    $blog->meta()->update([
                        'meta_title' => $data['meta_title'],
                        'meta_keywords' => $data['meta_keywords'],
                        'meta_description' => $data['meta_description']
                    ]);
                }
                return $blog;
            });
        } catch (Exception $e) {
            Log::error("Failed to update blog post", [
                'blog_id' => $id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * @throws Exception
     */
    public function delete($id):bool
    {
        try {
            return DB::transaction(function () use ($id) {
                $blog = Blog::findOrFail($id);
                if ($blog->photo) {
                    if (Storage::disk('public')->exists($blog->photo->url)) {
                        Storage::disk('public')->delete($blog->photo->url);
                    }
                    $blog->photo()->delete();
                }
                if ($blog->video) {
                    if (Storage::disk('public')->exists($blog->video->url)) {
                        Storage::disk('public')->delete($blog->video->url);
                    }
                    $blog->video()->delete();
                }
                $blog->meta()->delete();
                $blog->delete();

                return true;
            });
        } catch (Exception $e) {
            Log::error("Failed to delete blog post", [
                'blog_id' => $id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}
