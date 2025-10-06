<?php

namespace App\Models;

use App\Base\Trait\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use HasFactory, HasRules;

    protected $table = 'contacts';
    protected $fillable = [
        'full_name',
        'subject',
        'user_id',
        'mobile',
        'ip_address',
        'message',
        'read'
    ];

    protected static array $rules = [
        'full_name'=>'required|string|min:3|max:255',
        'subject'=>'required|string|max:255',
        'mobile'=>'required|ir_mobile:zero',
        'email'=>'nullable|email|max:255',
        'message'=>'required|string|min:3|max:500',
        'g-recaptcha-response' => 'required|captcha',
    ];

    protected function casts(): array
    {
        return [
            'created_at'=> 'datetime',
            'updated_at'=> 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
