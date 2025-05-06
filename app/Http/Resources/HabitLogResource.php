<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HabitLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
   // app/Http/Resources/HabitLogResource.php
public function toArray($request)
{
    return [
        'id' => $this->id,
        'habit_id' => $this->habit_id,
        'habit_title' => $this->habit->title ?? null,
        'date' => $this->date,
        'time_checked' => $this->time_checked,
        'note' => $this->note,
    ];
}

    
}
