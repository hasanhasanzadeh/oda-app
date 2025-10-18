<?php

namespace App\Models;

use App\Base\Trait\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, HasRules;

    protected $fillable = [
        'name',
        'name_en',
        'slug',
        'description',
        'price',
        'buy_price',
        'original_price',
        'discount',
        'quantity',
        'sku',
        'category_id',
        'photo_id',
        'status',
        'brand',
        'is_featured',
        'views',
        'specifications',
    ];

    protected static array $rules = [
        'name' => 'required|string|min:3|max:255|unique:products,name',
        'slug' => 'required|string|min:3|max:255|unique:products,slug',
        'name_en' => 'required|string|min:3|max:255',
        'brand' => 'nullable|string|min:3|max:255',
        'specifications' => 'nullable|array',
        'description' => 'nullable|string|max:10000',
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|numeric|min:0',
        'original_price' => 'required|numeric|min:0',
        'buy_price' => 'required|numeric|min:0',
        'discount' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0|max:999999',
        'status' => 'required|in:active,inactive,soon',
        'meta_title'=>'required|string|min:3|max:150',
        'meta_description'=>'required|string|min:3|max:500',
        'meta_keywords'=>'required|string|min:3|max:1500',
    ];

    protected $casts = [
        'specifications' => 'array',
        'is_featured' => 'boolean',
    ];

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    // Attributes
    public function getAverageRatingAttribute()
    {
        return $this->comments()
            ->where('is_approved', true)
            ->avg('rating') ?? 0;
    }

    public function getFinalPriceAttribute()
    {
        return $this->price;
    }

    // Scopes
    public function scopeActive($query)
    {
        if ($query->whereIn('status', ['active','soon'])) {
            $query->where('quantity', '>', 0);
        }
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 0);
    }


    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'active' => 'فعال',
            'inactive' => 'غیرفعال',
            'soon' => 'به زودی',
            default => 'نامشخص',
        };
    }

    public function photo():BelongsTo
    {
        return $this->belongsTo(File::class, 'photo_id','id');
    }

    public function gallery():morphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function meta():MorphOne
    {
        return $this->morphOne(Meta::class, 'metaable');
    }

    /*
     * ---------------------------
     *          Scopes
     * ---------------------------
     */

    public function scopeAvailable($query)
    {
        return $query->where('status', 'active')
                    ->where('quantity', '>', 0);
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('quantity', 0);
    }

    public function scopeLowStock($query, $threshold = 10)
    {
        return $query->where('quantity', '<=', $threshold)
                    ->where('quantity', '>', 0);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopePriceRange($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    /*
     * ---------------------------
     *          Accessors
     * ---------------------------
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0) . ' تومان ';
    }

    public function getIsOutOfStockAttribute(): bool
    {
        return $this->quantity == 0;
    }

    public function getIsLowStockAttribute(): bool
    {
        return $this->quantity > 0 && $this->quantity <= 10;
    }

    /*
     * ---------------------------
     *          Mutators
     * ---------------------------
     */
    public function setSkuAttribute($value): void
    {
        $this->attributes['sku'] = strtoupper($value);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($product) {
            $product->sku = $product->generateUniqueSku();
        });
    }

    public function generateUniqueSku(): string
    {
        do {
            $sku = strtoupper(Str::random(3)) . rand(10000, 99999);
        } while (self::where('sku', $sku)->exists());

        return $sku;
    }

}
