<?php

namespace App\Models;

use App\Base\Trait\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory, HasRules;

    protected $table = 'addresses';

    const ID = 'id';
    const TITLE = 'title';
    const CONTENT = 'content';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const USER_ID = 'user_id';

    protected $fillable = [
        self::TITLE,
        self::CONTENT,
        self::USER_ID
    ];

    protected $dates = [
        self::CREATED_AT,
        self::UPDATED_AT
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
