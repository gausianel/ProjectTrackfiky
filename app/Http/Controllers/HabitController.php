<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\HabitCategory;
use App\Http\Requests\StoreHabitRequest;
use App\Http\Resources\HabitResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HabitController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Habit::class, 'habit');
    }

    public function index(Request $request)
    {
        $query = Habit::where('user_id', Auth::id());

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        if (in_array($sortBy, ['title', 'created_at', 'updated_at']) && in_array($sortOrder, ['asc', 'desc'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $perPage = $request->input('per_page', 10);

        return HabitResource::collection($query->paginate($perPage));
    }

    public function store(StoreHabitRequest $request): HabitResource
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        if (!isset($data['schedule_type'])) {
            $data['schedule_type'] = 'daily';
        }

        return new HabitResource(Habit::create($data));
    }

    public function show(Habit $habit)
    {
        $this->authorize('view', $habit);
        return new HabitResource($habit);
    }

    public function update(Request $request, Habit $habit)
    {
        $this->authorize('update', $habit);
        $habit->update($request->all());
        return new HabitResource($habit);
    }

    public function destroy(Habit $habit)
    {
        $this->authorize('delete', $habit);
        $habit->delete();

        return response()->json(['message' => 'Habit deleted']);
    }

    public function summary($habitId)
    {
        $habit = Habit::where('id', $habitId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $totalLogs = $habit->logs()->count();

        return response()->json([
            'habit_id' => $habit->id,
            'title' => $habit->title,
            'total_logs' => $totalLogs,
        ]);
    }

    // ⬇⬇⬇ Tambahan untuk halaman edit
    public function edit(Habit $habit)
    {
        $this->authorize('update', $habit);

        $habitCategories = HabitCategory::all();

        return view('habits.edit', compact('habit', 'habitCategories'));
    }

   

}
