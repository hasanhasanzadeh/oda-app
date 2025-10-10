<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Base\Trait\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles, HasRules;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'father_name',
        'gender',
        'email',
        'national_code',
        'email_verified_at',
        'birthday',
        'role_type',
        'is_active',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static array $rules = [
        'first_name' => 'required|string|min:3|max:100',
        'last_name' => 'required|string|min:3|max:100',
        'gender' => 'required|in:female,male',
        'national_code' => 'nullable|digits:10|numeric|unique:users,national_code',
        'email' => 'nullable|email|max:255',
        'password' => 'nullable|string|min:4|max:32',
        'role_type' => 'required|in:admin,student,teacher,staff',
        'birthday' => 'nullable|date_format:Y-m-d',
        'is_active'=>'nullable|in:0,1',
        'mobile' => 'required|ir_mobile:zero|string',
    ];

    public function getGenderLabelAttribute():string
    {
        return match ($this->gender) {
            'female' => 'زن ' ,
            'male' => 'مرد ' ,
            default => 'مشخص نشده',
        };
    }

    public function getFullNameWithGenderAttribute(): string
    {
        $gender = $this->gender;
        return match ($gender) {
            'female' => 'خانم ' . $this->first_name . ' ' . $this->last_name,
            'male' => 'آقای ' . $this->first_name . ' ' . $this->last_name,
            default => $this->first_name . ' ' . $this->last_name,
        };
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getRoleTypeLabelAttribute(): string
    {
        $role_type = $this->role_type;
        return match ($role_type) {
            'user' => 'کاربر',
            'staff' => 'کارمند',
            'admin' => 'مدیر',
            default => '-',
        };
    }
    /*
     * --------------------------------------------
     *              Relations
     * --------------------------------------------
     */

    public function avatar(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable');
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
