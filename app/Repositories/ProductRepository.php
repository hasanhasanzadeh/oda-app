<?php
namespace App\Repositories;

use App\Helpers\Helper;
use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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

    public function create(array $data)
    {
        $product = Product::create($data);
        if (isset($data['image'])) {
            $path = str_replace('public', 'storage', $data['image']->store('public/products'));
            $product->photo()->create(['path' => $path]);
        }
        return $product;
    }

    public function update($id, array $data)
    {
        $product = Product::findOrFail($id);
        if (isset($data['image'])) {
            if ($product->photo) {
                Helper::deleteFile($product->photo->url);
                $product->photo()->delete();
            }
            $path = str_replace('public', 'storage', $data['image']->store('public/products'));
            $product->photo()->create(['path' => $path]);
        }
        $product->update($data);
        return $product;
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        if ($product->photo) {
            Helper::deleteFile($product->photo->url);
            $product->photo()->delete();
        }
        return $product->delete();
    }
}
