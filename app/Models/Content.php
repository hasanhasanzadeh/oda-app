<?php

namespace App\Models;

use App\Base\Trait\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Content extends Model
{
    use HasFactory, HasRules;

    protected $table = 'contents';
    protected $fillable = [
        'title',
        'type',
        'status',
        'description',
    ];
    protected static $rules = [
        'title'=>'required|string|min:2|max:70',
        'type'=>'required|string|in:contact-us,about-us,rules,privacy|unique:contents,type',
        'description'=>'required|min:3|string',
        'status'=>'required|boolean',
        'meta_title'=>'required|string|min:3|max:150',
        'meta_description'=>'required|string|min:3|max:500',
        'meta_keywords'=>'required|string|min:3|max:1500',
    ];


    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'contact-us' => 'ارتباط با ما',
            'about-us' => 'درباره ما',
            'rules' => 'قوانین و مقررات',
            'privacy' => 'حریم خصوصی',
            default => 'Unknown',
        };
    }
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
