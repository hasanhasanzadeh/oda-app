<?php

namespace App\Models;

use App\Base\Trait\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Blog extends Model
{
    use HasFactory, HasRules;

    protected $table = 'blogs';
    protected $fillable = [
        'title',
        'description',
        'view_count',
        'slug',
        'publish_date',
        'author_id',
        'status',
        'video_id',
    ];

    protected static array $rules = [
        'title' => 'required|string|min:3|max:255',
        'slug' => 'required|unique:blogs,slug|min:3|max:255',
        'publish_date' => 'nullable|date_format:Y-m-d',
        'description' => 'required|string|max:16777215',
        'status' => 'nullable|in:0,1',
        'meta_title'=>'required|string|min:2|max:255',
        'meta_description'=>'required|string|min:2|max:255',
        'meta_keywords'=>'required|string|min:2|max:65535',
        'tags' => 'nullable|array',
        'tags.*' => 'string|max:255',
    ];

    /*
     * ---------------------------
     *          Relations
     * ---------------------------
     */
    public function photo():morphOne
    {
        return $this->morphOne(File::class, 'fileable');
    }

    public function video():belongsTo
    {
        return $this->belongsTo(File::class, 'video_id','id');
    }

    public function author():belongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function meta():morphOne
    {
        return $this->morphOne(Meta::class, 'metaable');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

}
