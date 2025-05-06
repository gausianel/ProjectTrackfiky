<?php

namespace App\Http\Controllers;

use App\Models\HabitLog;
use App\Models\Habit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\HabitLogResource;
use Carbon\Carbon;

class HabitLogController extends Controller
{
    /**
     * Tampilkan semua habit log untuk hari ini.
     */
    public function index()
    {
        $today = Carbon::today();
        $userId = Auth::id();

        $userHabits = Habit::where('user_id', $userId)->pluck('id');

        $logs = HabitLog::with('habit')
            ->whereIn('habit_id', $userHabits)
            ->whereDate('date', $today)
            ->latest()
            ->get();

        return HabitLogResource::collection($logs);
    }

    /**
     * Auto-generate log untuk habits yang belum dicatat hari ini.
     */
    public function autoCreateLogs()
    {
        $today = Carbon::today();
        $userId = Auth::id();

        $userHabits = Habit::where('user_id', $userId)->pluck('id');
        $loggedToday = HabitLog::whereDate('date', $today)
            ->whereIn('habit_id', $userHabits)
            ->pluck('habit_id');

        $habitsToLog = $userHabits->diff($loggedToday);

        DB::beginTransaction();

        try {
            $createdLogs = [];

            foreach ($habitsToLog as $habitId) {
                $log = HabitLog::create([
                    'habit_id' => $habitId,
                    'date' => $today,
                    'time_checked' => null,
                    'note' => null,
                ]);
                $createdLogs[] = $log;
            }

            DB::commit();

            return response()->json([
                'message' => 'Habit logs auto-created successfully.',
                'logs' => HabitLogResource::collection($createdLogs),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Failed to auto-create habit logs', [
                'error' => $e->getMessage(),
                'user_id' => $userId,
                'date' => $today,
            ]);

            return response()->json([
                'message' => 'Failed to auto-create habit logs.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Simpan habit log baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'habit_id' => 'required|exists:habits,id',
            'time_checked' => 'required|date_format:H:i',
            'note' => 'nullable|string|max:100',
        ]);

        $habit = Habit::where('id', $validated['habit_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $today = Carbon::today();

        $existingLog = HabitLog::where('habit_id', $habit->id)
            ->whereDate('date', $today)
            ->first();

        if ($existingLog) {
            return response()->json([
                'message' => 'Log for today already exists.',
            ], 409);
        }

        $log = HabitLog::create([
            'habit_id' => $habit->id,
            'date' => $today,
            'time_checked' => Carbon::createFromFormat('H:i', $validated['time_checked']),
            'note' => $validated['note'] ?? null,
        ]);

        return new HabitLogResource($log);
    }

    /**
     * Tampilkan detail log berdasarkan ID.
     */
    public function show($id)
    {
        $log = HabitLog::with('habit')->findOrFail($id);

        abort_if($log->habit->user_id !== Auth::id(), 403, 'Unauthorized');

        return new HabitLogResource($log);
    }

    /**
     * Update log yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'time_checked' => 'required|date_format:H:i',
            'note' => 'nullable|string|max:100',
        ]);

        $log = HabitLog::with('habit')->findOrFail($id);

        abort_if($log->habit->user_id !== Auth::id(), 403, 'Unauthorized');

        $log->update([
            'time_checked' => Carbon::createFromFormat('H:i', $validated['time_checked']),
            'note' => $validated['note'] ?? null,
        ]);

        return new HabitLogResource($log);        
    }

    /**
     * Hapus habit log.
     */
    public function destroy($id)
    {
        $log = HabitLog::with('habit')->findOrFail($id);

        abort_if($log->habit->user_id !== Auth::id(), 403, 'Unauthorized');

        $log->delete();

        return response()->json(['message' => 'Log deleted'], 200);
    }
}
