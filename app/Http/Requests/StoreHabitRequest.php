<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHabitRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'category_id' => 'required|exists:habit_categories,id',
            'schedule_type' => 'required|in:daily,weekly', // <<< INI lebih kuat
        ];
    }
}
