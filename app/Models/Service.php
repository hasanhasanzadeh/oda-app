<?php

namespace App\Models;

use App\Base\Trait\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Service extends Model
{

    use HasFactory, HasRules;

    protected $table = 'services';
    protected $fillable = [
        'title',
        'description',
        'status',
        'link'
    ];

    protected static array $rules = [
        'title'=>'required|string|min:2|max:255',
        'description'=>'required|string|min:2|max:65535',
        'status'=>'required|boolean',
        'link'=>'nullable|url',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5200',
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
}
