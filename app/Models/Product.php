<?php

namespace App\Models;

use App\Base\Trait\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, HasRules;

    /*
     * ---------------------------
     *          Constants
     * ---------------------------
     */
    const ID = 'id';
    const NAME = 'name';
    const NAME_EN = 'name_en';
    const DESCRIPTION = 'description';
    const CATEGORY_ID = 'category_id';
    const PRICE = 'price';
    const ORIGINAL_PRICE = 'original_price';
    const DISCOUNT = 'discount';
    const BUY_PRICE = 'buy_price';
    const QUANTITY = 'quantity';
    const SLUG = 'slug';
    const SKU = 'sku';
    const STATUS = 'status';
    const PHOTO_ID = 'photo_id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';

    protected $fillable = [
        self::NAME,
        self::NAME_EN,
        self::SLUG,
        self::DESCRIPTION,
        self::CATEGORY_ID,
        self::PHOTO_ID,
        self::PRICE,
        self::BUY_PRICE,
        self::ORIGINAL_PRICE,
        self::DISCOUNT,
        self::QUANTITY,
        self::SKU,
        self::STATUS,
    ];

    protected $casts = [
        self::ID => 'int',
        self::PRICE => 'string',
        self::BUY_PRICE => 'string',
        self::ORIGINAL_PRICE => 'string',
        self::QUANTITY => 'integer',
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime',
    ];

    protected $attributes = [
        self::QUANTITY => 0,
    ];

    protected static array $rules = [
        'name' => 'required|string|min:3|max:255|unique:products,name',
        'slug' => 'required|string|min:3|max:255|unique:products,slug',
        'name_en' => 'required|string|min:3|max:255',
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

    /*
     * ---------------------------
     *          Relations
     * ---------------------------
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
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
        return $query->where(self::STATUS, 'active')
                    ->where(self::QUANTITY, '>', 0);
    }

    public function scopeOutOfStock($query)
    {
        return $query->where(self::QUANTITY, 0);
    }

    public function scopeLowStock($query, $threshold = 10)
    {
        return $query->where(self::QUANTITY, '<=', $threshold)
                    ->where(self::QUANTITY, '>', 0);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where(self::CATEGORY_ID, $categoryId);
    }

    public function scopePriceRange($query, $min, $max)
    {
        return $query->whereBetween(self::PRICE, [$min, $max]);
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
    public function setSkuAttribute($value)
    {
        $this->attributes[self::SKU] = strtoupper($value);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->sku = $product->generateUniqueSku();
        });
    }

    public function generateUniqueSku()
    {
        do {
            $sku = strtoupper(Str::random(3)) . rand(10000, 99999);
        } while (self::where('sku', $sku)->exists());

        return $sku;
    }

}
