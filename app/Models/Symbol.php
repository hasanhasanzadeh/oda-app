<?php

namespace App\Models;

use App\Base\Trait\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Symbol extends Model
{
    use HasFactory, HasRules;

    protected $table = 'symbols';
    protected $fillable = [
        'title',
        'description',
        'status',
        'link',
        'setting_id'
    ];

    protected static array $rules = [
        'title'=>'required|string|min:2|max:255|unique:symbols,title',
        'description'=>'required|string|min:2|max:65535',
        'link'=>'required|url|max:255',
        'status'=>'required|boolean',
        'image'=>'required|image|mimes:png,jpg,webp,jpeg,gif,svg,bmp,avif|max:5048',
        'setting_id'=>'required|exists:settings,id',
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

    public function setting(): BelongsTo
    {
        return $this->belongsTo(Setting::class,'setting_id','id');
    }
}
