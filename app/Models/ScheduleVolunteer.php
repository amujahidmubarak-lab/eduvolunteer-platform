<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleVolunteer extends Model
{
    protected $fillable = [
        'teaching_schedule_id',
        'user_id',
        'attendance_status',
    ];

    public function teachingSchedule()
    {
        return $this->belongsTo(TeachingSchedule::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
