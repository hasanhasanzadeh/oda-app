<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class OtpCode extends Model
{
    use HasFactory,Notifiable;
    protected $fillable = [
        'phone',
        'code',
        'expires_at',
        'verified',
        'ip_address'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified' => 'boolean',
    ];

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isValid(): bool
    {
        return !$this->verified && !$this->isExpired();
    }

    public static function generate(string $phone, string $ip = null): self
    {
        static::where('phone', $phone)
            ->where('verified', false)
            ->delete();

        return static::create([
            'phone' => $phone,
            'code' => str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT),
            'expires_at' => Carbon::now()->addMinutes(2),
            'ip_address' => $ip,
        ]);
    }
}
