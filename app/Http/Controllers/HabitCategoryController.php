<?php

namespace App\Http\Controllers;

use App\Models\HabitCategory;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class HabitCategoryController extends Controller
{
    // GET /api/categories
    public function index()
    {
        return response()->json(HabitCategory::all());
    }

    // POST /api/categories
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100'
        ]);

        $category = HabitCategory::create([
            'name' => $validated['name'],
        ]);

        return response()->json($category, 201);
    }

    // GET /api/categories/{id}
    public function show($id)
    {
        $category = HabitCategory::findOrFail($id);
        return response()->json($category);
    }

    // PUT /api/categories/{id}
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100'
        ]);

        $category = HabitCategory::findOrFail($id);
        $category->update($validated);

        return response()->json($category);
    }

    // DELETE /api/categories/{id}
    public function destroy($id)
    {
        $category = HabitCategory::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Category deleted']);
    }

    
}
