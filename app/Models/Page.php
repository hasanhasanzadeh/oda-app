<?php

namespace App\Models;

use App\Base\Trait\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Page extends Model
{
    use HasFactory, HasRules;

    protected $table = 'pages';
    protected $fillable = [
        'title',
        'slug',
        'status',
        'description',
    ];
    protected static array $rules = [
        'title'=>'required|string|min:2|max:255',
        'slug'=>'required|string|max:255|unique:pages,slug',
        'description'=>'required|min:3|string',
        'status'=>'required|boolean',
        'meta_title'=>'required|string|min:3|max:150',
        'meta_description'=>'required|string|min:3|max:500',
        'meta_keywords'=>'required|string|min:3|max:1500',
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

    public function meta():morphOne
    {
        return $this->morphOne(Meta::class, 'metaable');
    }
}
