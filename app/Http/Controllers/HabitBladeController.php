<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Habit;
use App\Models\HabitCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HabitBladeController extends Controller
{
    public function index()
    {
        $habits = Habit::where('user_id', Auth::user()->id)->get();
        return view('habits.index', compact('habits'));
    }

    public function create()
    {
        $categories = \App\Models\HabitCategory::all();
        return view('habits.create', compact('categories'));
    }
    
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:habit_categories,id',
            'schedule_type' => 'required|in:daily,weekly,monthly',
        ]);
        
        $data['user_id'] = Auth::id();
        Habit::create($data);

        return redirect()->route('habits.index')->with('success', 'Habit created successfully.');
    }

    public function edit(Habit $habit)
    {
        $this->authorize('update', $habit);
        $habitCategories = HabitCategory::all(); // Tambahkan ini
        return view('habits.edit', compact('habit', 'habitCategories'));
    }
    

    public function update(Request $request, Habit $habit)
    {
        $this->authorize('update', $habit);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:habit_categories,id',
        ]);

        $habit->update($data);

        return redirect()->route('habits.index')->with('success', 'Habit updated successfully.');
    }

    public function destroy(Habit $habit)
    {
        $this->authorize('delete', $habit);
        $habit->delete();

        return redirect()->route('habits.index')->with('success', 'Habit deleted successfully.');
    }
}
