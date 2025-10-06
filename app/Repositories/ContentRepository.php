<?php
namespace App\Repositories;

use App\Helpers\Helper;
use App\Models\Content;
use App\Repositories\Interfaces\ContentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContentRepository implements ContentRepositoryInterface
{
    public function all(array $filters = []): LengthAwarePaginator
    {
        $perPage = $filters['per_page']??10;
        $column = $filters['sort']??'created_at';
        $direction = $filters['direction']??'desc';

        $allowedPerPage = [10, 25, 50, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }
        $allowedColumns = ['title', 'status','type', 'id', 'created_at'];
        if (!in_array($column, $allowedColumns)) {
            $column = 'created_at';
        }
        $abouts = Content::query();

        if ($keyword = request('search')) {
            $abouts->where('title', 'LIKE', "%{$keyword}%");
        }
        if ($status = request('status')) {
            $abouts->where('status', 'LIKE', "%{$status}%");
        }
        return $abouts->with('photo','meta')->orderBy($column, $direction === 'asc' ? 'asc' : 'desc')->paginate($perPage);
    }

    public function find($id)
    {
        return Content::findOrFail($id);
    }

    public function getByType($type)
    {
        return Content::whereType($type)->first();
    }

    public function create(array $data)
    {
        $about = Content::create($data);
        if (isset($data['image'])) {
            $path = str_replace('public', 'storage', $data['image']->store('public/pages'));
            $about->photo()->create(['path' => $path]);
        }
        $about->meta()->create([
            'meta_title' => $data['meta_title'],
            'meta_keywords' => $data['meta_keywords'],
            'meta_description' => $data['meta_description']
        ]);
        return $about;
    }

    public function update($id, array $data)
    {
        $about = Content::findOrFail($id);
        $about->update($data);
        if (isset($data['image'])) {
            if ($about->photo) {
                Helper::deleteFile($about->photo->url);
                $about->photo()->delete();
            }
            $path = str_replace('public', 'storage', $data['image']->store('public/pages'));
            $about->photo()->create(['path' => $path]);
        }
        $about->meta()->update([
            'meta_title' => $data['meta_title'],
            'meta_keywords' => $data['meta_keywords'],
            'meta_description' => $data['meta_description']
        ]);
        return $about;
    }

    public function delete($id)
    {
        $about = Content::findOrFail($id);
        if ($about->photo) {
            Helper::deleteFile($about->photo->url);
            $about->photo()->delete();
        }
        $about->meta()->delete();
        return $about->delete();
    }
}
