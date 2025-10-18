<?php

namespace App\Models;

use App\Base\Trait\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Setting extends Model
{
    use HasFactory, HasRules;

    protected $table = 'settings';
    protected $fillable = [
        'title',
        'short_text',
        'url',
        'email',
        'tel',
        'phone',
        'support_text',
        'address',
        'script_text',
        'description',
        'copy_right',
        'logo_id',
        'favicon_id',
    ];

    protected static array $rules = [
        'title'=>'required|string|max:255|unique:settings,title',
        'description'=>'nullable|string|max:65535',
        'short_text'=>'required|string|max:255',
        'copy_right'=>'required|string|max:255',
        'url'=>'required|string|max:255',
        'tel'=>'required|string|max:18',
        'phone'=>'nullable|string|max:18',
        'email'=>'required|string|max:255',
        'script_text'=>'nullable|string',
        'address'=>'required|string|max:255',
        'support_text'=>'required|string|max:255',
        'meta_title'=>'required|string|min:2|max:255',
        'meta_description'=>'required|string|min:2|max:255',
        'meta_keywords'=>'required|string|min:2|max:255',
        'telegram'=>'nullable|url|max:255',
        'instagram'=>'nullable|url|max:255',
        'facebook'=>'nullable|url|max:255',
        'whatsapp'=>'nullable|url|max:255',
        'youtube'=>'nullable|url|max:255',
        'x_link'=>'nullable|url|max:255',
        'linkedin'=>'nullable|url|max:255',
        'github'=>'nullable|url|max:255',
        'dribble'=>'nullable|url|max:255',
        'map_data'=>'nullable|string|max:50',
    ];

    /*
     * ---------------------------
     *          Relations
     * ---------------------------
     */
    public function logo():belongsTo
    {
        return $this->belongsTo(File::class, 'logo_id','id');
    }

    public function favicon():belongsTo
    {
        return $this->belongsTo(File::class, 'favicon_id','id');
    }

    public function socialMedia():morphOne
    {
        return $this->morphOne(SocialMedia::class,'socialmediaable');
    }

    public function meta():morphOne
    {
        return $this->morphOne(Meta::class,'metaable');
    }

    public function symbols():hasMany
    {
        return $this->hasMany(Symbol::class,'setting_id','id');
    }
}
