<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\HabitCategory;

class Habit extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'schedule_type',
    ];

    protected $primaryKey = 'id';    // tambahkan ini
    public $incrementing = true;     // tambahkan ini
    protected $keyType = 'int';       // tambahkan ini

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(HabitCategory::class, 'category_id');
    }

    public function logs()
    {
        return $this->hasMany(HabitLog::class);
    }
}
