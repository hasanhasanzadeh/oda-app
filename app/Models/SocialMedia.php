<?php

namespace App\Models;

use App\Base\Trait\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SocialMedia extends Model
{
    use HasFactory, HasRules;

    protected $table='social_media';
    protected $fillable=[
        'telegram',
        'instagram',
        'facebook',
        'whatsapp',
        'youtube',
        'x_link',
        'linkedin',
        'map_data',
        'google_plus',
    ];

    protected static array $rules = [
        'telegram'=>'required|url|max:255',
        'instagram'=>'required|url|max:255',
        'facebook'=>'nullable|url|max:255',
        'whatsapp'=>'nullable|url|max:255',
        'youtube'=>'nullable|url|max:255',
        'x_link'=>'nullable|url|max:255',
        'linkedin'=>'nullable|url|max:255',
        'map_data'=>'nullable|string|max:50',
        'google_plus'=>'required|url|max:255',
    ];


    /*
     * ---------------------------
     *          Relations
     * ---------------------------
     */
    public function socialmediaable():morphTo
    {
        return $this->morphTo();
    }
}
