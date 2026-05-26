<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerProfile extends Model
{
    protected $fillable = [
        'user_id',
        'whatsapp',
        'campus_major',
        'domicile',
        'interested_subjects',
        'availability',
        'motivation',
        'ktm_photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
