<?php
namespace App\Repositories;

use App\Helpers\Helper;
use App\Models\Page;
use App\Repositories\Interfaces\PageRepositoryInterface;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PageRepository implements PageRepositoryInterface
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

        $allowedColumns = ['id','title', 'status', 'created_at'];
        if (!in_array($column, $allowedColumns)) {
            $column = 'created_at';
        }
        $data = Page::query();

        if ($keyword = request('search')) {
            $data->where('title', 'LIKE', "%{$keyword}%");
        }
        if ($status = request('status')) {
            $data->where('status', 'LIKE', "%{$status}%");
        }
        if (!empty($filters['from_date']) || !empty($filters['to_date'])) {
            $from_date = $filters['from_date'] ?? null;
            $to_date = $filters['to_date'] ?? null;

            $data = $data->when($from_date, fn($q) => $q->whereDate('created_at', '>=', $from_date))
                ->when($to_date, fn($q) => $q->whereDate('created_at', '<=', $to_date));
        }
        return $data->with('photo')->orderBy($column, $direction === 'asc' ? 'asc' : 'desc')->paginate($perPage);
    }

    public function find($id)
    {
        return Page::findOrFail($id);
    }

    public function findBySlug($slug): ?Page
    {
        $page =Page::where([
            ['status', true],
            ['slug', $slug],
        ])->firstOrFail();
        $page->increment('view_count');
        return $page;
    }

    /**
     * @throws Exception
     */
    public function create(array $data):Page
    {
        try {
            return DB::transaction(function () use ($data) {
                $page = Page::create($data);
                if (isset($data['image'])) {
                    $path = str_replace('public', 'storage', $data['image']->store('public/pages'));
                    $page->photo()->create(['path' => $path]);
                }
                $page->meta()->create([
                    'meta_title' => $data['meta_title'],
                    'meta_keywords' => $data['meta_keywords'],
                    'meta_description' => $data['meta_description']
                ]);
                return $page;
            });
        } catch (Exception $e) {
            Log::error("Failed to create page post", [
                'page' => $data,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }

    }

    /**
     * @throws Exception
     */
    public function update($id, array $data):Page
    {
        try {
            return DB::transaction(function () use ($data,$id) {
                $page = Page::findOrFail($id);
                $page->update($data);
                if (isset($data['image'])) {
                    if ($page->photo) {
                        Helper::deleteFile($page->photo->url);
                        $page->photo()->delete();
                    }
                    $path = str_replace('public', 'storage', $data['image']->store('public/pages'));
                    $page->photo()->create(['path' => $path]);
                }
                if (empty($page->meta)) {
                    $page->meta()->create([
                        'meta_title' => $data['meta_title'],
                        'meta_keywords' => $data['meta_keywords'],
                        'meta_description' => $data['meta_description']
                    ]);
                } else {
                    $page->meta()->update([
                        'meta_title' => $data['meta_title'],
                        'meta_keywords' => $data['meta_keywords'],
                        'meta_description' => $data['meta_description']
                    ]);
                }
                return $page;
            });
        } catch (Exception $e) {
            Log::error("Failed to update page post", [
                'page_id' => $id,
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
                $page = Page::findOrFail($id);
                if ($page->photo) {
                    if (Storage::disk('public')->exists($page->photo->url)) {
                        Storage::disk('public')->delete($page->photo->url);
                    }
                    $page->photo()->delete();
                }
                $page->meta()->delete();
                $page->delete();

                return true;
            });
        } catch (Exception $e) {
            Log::error("Failed to delete page post", [
                'page_id' => $id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}
