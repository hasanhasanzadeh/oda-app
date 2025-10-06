<?php

namespace App\Models;

use App\Base\Trait\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Visit extends Model
{
    use HasFactory, HasRules;

    protected $table='visits';
    protected $fillable=[
        'user_id',
        'role',
        'url',
        'ip_address',
        'score'
    ];

    public function user():belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
