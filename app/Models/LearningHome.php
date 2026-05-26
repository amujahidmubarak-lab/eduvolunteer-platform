<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LearningHome extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'pic_name',
        'contact_number',
        'student_count',
        'latitude',
        'longitude',
    ];

    public function teachingSchedules()
    {
        return $this->hasMany(TeachingSchedule::class);
    }
}
