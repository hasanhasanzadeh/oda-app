<?php

namespace App\Models;

use App\Base\Trait\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    use HasFactory, HasRules;

    protected $table = 'provinces';
    protected $fillable = [
        'name',
        'country_id'
    ];
    protected static array $rules = [
        'name'=>'required|string|min:2|max:70',
        'country_id'=>'required|exists:countries,id',
    ];

    /*
     * ---------------------------
     *          Relations
     * ---------------------------
     */

    public function country():belongsTo
    {
        return $this->belongsTo(Country::class,'country_id','id');
    }

    public function cities():hasMany
    {
        return $this->hasMany(City::class,'province_id','id');
    }

    /**
     *
     *  create provinces mysql
     *
        INSERT INTO `provinces` (`id`, `name`) VALUES (1, 'آذربایجان شرقی'), (2, 'آذربایجان غربی'), (3, 'اردبیل'), (4, 'اصفهان'), (5, 'البرز'), (6, 'ایلام'), (7, 'بوشهر'), (8, 'تهران'), (9, ' چهارمحال و بختیاری'), (10, 'خراسان جنوبی'), (11, 'خراسان رضوی'), (12, 'خراسان شمالی'), (13, 'خوزستان'), (14, 'زنجان'), (15, 'سمنان'), (16, 'سیستان و بلوچستان'), (17, 'فارس'), (18, 'قزوین'), (19, 'قم'), (20, 'کردستان'), (21, 'کرمان'), (22, 'کرمانشاه'), (23, ' کهگیلویه وبویراحمد'), (24, 'گلستان'), (25, 'گیلان'), (26, 'لرستان'), (27, 'مازندران'), (28, 'مرکزی'), (29, 'هرمزگان'), (30, 'همدان'), (31, 'یزد');
     *
     */
}
