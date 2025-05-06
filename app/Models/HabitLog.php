<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HabitLog extends Model
{
    protected $fillable = [
        'habit_id',
        'date',
        'time_checked',
        'note',
    ];

    public function habit()
    {
        return $this->belongsTo(Habit::class);
    }
}
