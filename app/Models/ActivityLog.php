<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = ['user_id', 'action', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function record($action, $description)
    {
        self::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'description' => $description,
        ]);
    }
}
