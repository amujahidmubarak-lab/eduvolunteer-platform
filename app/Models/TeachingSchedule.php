<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeachingSchedule extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'learning_home_id',
        'subject',
        'schedule_date',
        'start_time',
        'end_time',
        'status',
        'notes',
        'attendance_token',
    ];

    protected static function booted()
    {
        static::creating(function ($schedule) {
            if (empty($schedule->attendance_token)) {
                $schedule->attendance_token = \Illuminate\Support\Str::random(10);
            }
        });
    }

    protected function casts(): array
    {
        return [
            'schedule_date' => 'date',
        ];
    }

    public function learningHome()
    {
        return $this->belongsTo(LearningHome::class);
    }

    public function scheduleVolunteers()
    {
        return $this->hasMany(ScheduleVolunteer::class);
    }

    public function teachingReports()
    {
        return $this->hasMany(TeachingReport::class);
    }

    public function volunteers()
    {
        return $this->belongsToMany(User::class, 'schedule_volunteers', 'teaching_schedule_id', 'user_id')
                    ->withPivot('attendance_status', 'id')
                    ->withTimestamps();
    }
}
