<?php

namespace App\Models;

use App\Base\Trait\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Category extends Model
{
    use HasFactory, HasRules;

    protected $table = 'categories';
    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static array $rules = [
        'name' => 'required|string|min:3|max:255',
        'slug' => 'required|string|min:3|max:255|unique:categories,slug',
        'description' => 'nullable|string|min:3|max:10000',
        'parent_id' => 'nullable|exists:categories,id',
        'is_active' => 'nullable|in:1,0',
        'order' => 'nullable|numeric|min:0',
        'meta_title' => 'required|string|min:3|max:150',
        'meta_description' => 'required|string|min:3|max:255',
        'meta_keywords' => 'required|string|min:3|max:500',
    ];

    /*
     * ---------------------------
     *          Relations
     * ---------------------------
     */
    public function photo(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable');
    }

    // Relationships
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('order');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }

    public function meta(): MorphOne
    {
        return $this->morphOne(Meta::class,'metaable');
    }
}
