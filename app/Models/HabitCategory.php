<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HabitCategory extends Model
{
    protected $fillable = ['name',];



    public function habits()
{
    return $this->hasMany(Habit::class);
}



}
