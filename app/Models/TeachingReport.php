<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeachingReport extends Model
{
    protected $fillable = [
        'teaching_schedule_id',
        'user_id',
        'material_taught',
        'student_count',
        'obstacles',
        'evaluation',
        'photo_path',
    ];

    public function teachingSchedule()
    {
        return $this->belongsTo(TeachingSchedule::class)->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
