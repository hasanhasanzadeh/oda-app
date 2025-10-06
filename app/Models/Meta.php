<?php

namespace App\Models;

use App\Base\Trait\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Meta extends Model
{
    use HasFactory, HasRules;

    protected $table='metas';
    protected $fillable=[
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected static array $rules = [
        'meta_title'=>'required|string|max:255',
        'meta_description'=>'required|string|max:255',
        'meta_keywords'=>'required|string|max:65535',
    ];

    /*
     * ---------------------------
     *          Relations
     * ---------------------------
     */
    public function metaable():morphTo
    {
        return $this->morphTo();
    }
}
