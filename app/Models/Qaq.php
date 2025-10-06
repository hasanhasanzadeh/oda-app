<?php

namespace App\Models;

use App\Base\Trait\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Qaq extends Model
{
    use HasFactory, HasRules;

    protected $table = 'faqs';
    protected $fillable = [
        'title',
        'description',
        'status',
    ];

    protected static array $rules = [
        'title'=>'required|string|min:2|max:255',
        'description'=>'required|string|min:2|max:65535',
        'status'=>'required|boolean',
    ];
}
