<?php

namespace App\Models;

use App\Base\Trait\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class File extends Model
{
    protected $table = 'files';
    protected $fillable = [
        'title',
        'path',
        'filename',
        'type',
        'mimes',
        'width',
        'height',
        'size',
        'time',
        'fileable_id',
        'fileable_type',
    ];


    public function getAddressAttribute(): string
    {
        return '/'.$this->attributes['path'];
    }

    public function getAddAttribute(): string
    {
        return url('/').$this->attributes['path'];
    }

    public function getUrlAttribute(): string
    {
        $path = str_replace('storage/', '', $this->attributes['path']);
        return '/' . $path;
    }

    /*
     * ---------------------------
     *          Relations
     * ---------------------------
     */
    public function fileable():morphTo
    {
        return $this->morphTo();
    }
}
