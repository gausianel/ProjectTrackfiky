<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Habit;
use App\Models\HabitLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HabitLogBladeController extends Controller
{
    public function index()
    {
        $logs = HabitLog::with('habit')
            ->whereHas('habit', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->latest()
            ->get();
            

        return view('logs.index', compact('logs'));
    }

    public function create()
    {
        $habits = Habit::where('user_id', Auth::user()->id)->get();
        return view('logs.create', compact('habits'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'habit_id' => 'required|exists:habits,id',
            'time_checked' => 'required|date_format:H:i',
            'note' => 'nullable|string|max:255',
        ]);

        $data['date'] = now()->toDateString();
        HabitLog::create($data);

        return redirect()->route('logs.index')->with('success', 'Log created successfully.');
    }


    public function edit($id)
{
    $log = HabitLog::with('habit')->findOrFail($id);

    // Cek apakah user berhak mengedit
    if ($log->habit->user_id !== Auth::id()) {
        abort(403);
    }

    return view('logs.edit', compact('log'));
}

public function update(Request $request, $id)
{
    $log = HabitLog::with('habit')->findOrFail($id);

    // Cek apakah user berhak mengedit
    if ($log->habit->user_id !== Auth::id()) {
        abort(403);
    }

    $validated = $request->validate([
        'time_checked' => 'required|date_format:H:i',
        'note' => 'nullable|string|max:255',
    ]);

    $log->update($validated);

    return redirect()->route('logs.index')->with('success', 'Log updated successfully.');
}

}
