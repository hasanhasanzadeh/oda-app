<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivationCode extends Model
{
    use HasFactory;
    protected $table = "activation_codes";
    protected $fillable = [
        'used',
        'code',
        'user_id',
        'expired_at',
    ];

    public function scopeCreateCode($query, $user)
    {
        $code = $this->code();
        return $query->create([
            'user_id' => $user->id,
            'code' => $code,
            'expired_at' => Carbon::now()->addMinutes((int)config('expired.time_expired_at_activation_code')),
        ]);
    }

    private function code(): int
    {
        $digits = (int)config('expired.digits_count');
        $min = pow(10, $digits - 1);
        $max = pow(10, $digits) - 1;

        do {
            $code = mt_rand($min, $digits == 1 ? 9 : $max);
            $check_code = static::whereCode($code)->exists();
        } while ($check_code);

        return $code;
    }

    /*
     * --------------------------------------------
     *              Relations
     * --------------------------------------------
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
