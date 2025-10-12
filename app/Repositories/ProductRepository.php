<?php
namespace App\Repositories;

use App\Helpers\Helper;
use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryInterface
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
        $products = Product::query();

        if ($keyword =  request('search')) {
            $products->where('name', 'LIKE', "%{$keyword}%")
                ->orWhere('sku', 'LIKE', "%{$keyword}%");
        }
        if (!empty($filters['from_date']) || !empty($filters['to_date'])) {
            $from_date = $filters['from_date'] ?? null;
            $to_date = $filters['to_date'] ?? null;

            $products = $products->when($from_date, fn($q) => $q->whereDate('created_at', '>=', $from_date))
                ->when($to_date, fn($q) => $q->whereDate('created_at', '<=', $to_date));
        }
        return $products->with(['photo'])->orderBy($column, $direction === 'asc' ? 'asc' : 'desc')->paginate($perPage);
    }

    public function find($id)
    {
        return Product::findOrFail($id);
    }

    public function findBySlug($slug)
    {
        return Product::where('slug', $slug)->with(['photo','meta','gallery'])->firstOrFail();
    }
    public function create(array $data)
    {
        DB::transaction(function () use ($data) {
            $data['photo_id'] = Helper::uploadImage($data['image']);
            $product = Product::create($data);
            $product->meta()->create([
                'meta_title'=>$data['meta_title'],
                'meta_keywords'=>$data['meta_keywords'],
                'meta_description'=>$data['meta_description']
            ]);
            if (isset($data['gallery']) && is_array($data['gallery'])){
                foreach ($data['gallery'] as $gallery){
                    $path=str_replace('public','storage',$gallery->store('public/products'));
                    $product->gallery()->create(['path'=>$path]);
                }
            }
            return $product;
        });

    }

    public function update($id, array $data)
    {
        DB::transaction(function () use ($id, $data) {
            $product = Product::findOrFail($id);
            if (isset($data['image'])){
                if ($product->photo){
                    Helper::deleteFile($product->photo->url);
                    $product->photo()->delete();
                }
                $data['photo_id'] = Helper::uploadImage($data['image']->file('image'));
            }
            if (isset($data['gallery']) && is_array($data['gallery'])){
                if ($product->gallery){
                    foreach ($product->gallery as $photo){
                        Helper::deleteFile($photo->url);
                    }
                    $product->gallery()->delete();
                }
                foreach ($data['gallery'] as $gallery){
                    $path=str_replace('public','storage',$gallery->store('public/products'));
                    $product->gallery()->create(['path'=>$path]);
                }
            }
            $product->meta()->find($product->meta->id)->update([
                'meta_title'=>$data['meta_title'],
                'meta_keywords'=>$data['meta_keywords'],
                'meta_description'=>$data['meta_description']
            ]);
            $product->update($data);
            return $product;
        });
    }

    public function delete($id)
    {
        DB::transaction(function () use ($id) {
            $product = Product::findOrFail($id);
            if ($product->photo) {
                Helper::deleteFile($product->photo->url);
                $product->photo()->delete();
            }
            if ($product->gallery){
                foreach ($product->gallery as $photo){
                    Helper::deleteFile($photo->url);
                }
                $product->gallery()->delete();
            }
            return $product->delete();
        });
    }
}
