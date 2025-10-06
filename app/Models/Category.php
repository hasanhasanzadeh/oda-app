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
        'parent_id',
        'status',
    ];

    protected static array $rules = [
        'name' => 'required|string|min:3|max:255',
        'slug' => 'required|string|min:3|max:255|unique:categories,slug',
        'parent_id' => 'nullable|exists:categories,id',
        'status' => 'nullable|in:1,0',
        'image'=>'nullable|image|mimes:png,jpg,webp,jpeg,gif,svg,bmp,avif|max:5048',
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

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function meta(): MorphOne
    {
        return $this->morphOne(Meta::class,'metaable');
    }
}
