<?php

namespace App\Models;

use App\Base\Trait\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Country extends Model
{
    use HasFactory, HasRules;

    protected $table = 'countries';
    protected $fillable = [
        'country_name',
        'country_code',
        'country_persian_name',
    ];

    protected static array $rules = [
        'country_name'=>'required|string|min:2|max:70|unique:countries,country_name',
        'country_code'=>'required|string|max:2|unique:countries,country_code',
        'country_persian_name'=>'required|string|max:70|unique:countries,country_persian_name',
        'flag'=>'nullable|image|mimes:png,jpg,webp,jpeg,gif,svg,bmp,avif|max:5200',
    ];

    /*
     * ---------------------------
     *          Relations
     * ---------------------------
     */

    public function provinces():hasMany
    {
        return $this->hasMany(Province::class);
    }

    public function flag():morphOne
    {
        return $this->morphOne(File::class, 'fileable');
    }
}
