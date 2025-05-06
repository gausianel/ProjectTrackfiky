@extends('layouts.app')

@section('content')
<div class="relative min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-500 to-purple-700 py-8 overflow-hidden">
    
    {{-- Decorative Icons (Enhanced Visibility + Animation) --}}
    <div class="absolute inset-0 z-0 pointer-events-none">
        @for ($i = 0; $i < 25; $i++)
            <div 
                class="text-white opacity-30 absolute text-5xl animate-float-slow"
                style="
                    top: {{ rand(0, 95) }}%;
                    left: {{ rand(0, 95) }}%;
                    transform: rotate({{ rand(0, 360) }}deg);
                    animation-delay: {{ rand(0, 500) / 100 }}s;
                "
            >
                @php
                    $icons = ['📅', '✏️', '🗂️', '🔁', '📘', '🔧', '📝', '📍'];
                    echo $icons[array_rand($icons)];
                @endphp
            </div>
        @endfor
    </div>

    <div class="relative bg-white p-8 rounded-lg shadow-md w-full max-w-md z-10">
        <h1 class="text-2xl font-bold mb-6 text-center text-purple-600">Edit Habit</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('habits.update', $habit->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1 text-gray-700 font-medium">Title</label>
                <input type="text" name="title" value="{{ old('title', $habit->title) }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-400" required>
            </div>

            <div>
                <label class="block mb-1 text-gray-700 font-medium">Category</label>
                <select name="category_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-400">
                    <option value="">-- None --</option>
                    @foreach ($habitCategories as $category)
                        <option value="{{ $category->id }}" {{ $habit->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('habits.index') }}" class="text-sm text-gray-500 hover:underline">Cancel</a>

                <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-full hover:bg-purple-700 transition-all">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Custom Animation Style --}}
<style>
@keyframes float-slow {
    0%, 100% { transform: translateY(0) rotate(0); }
    50% { transform: translateY(-10px) rotate(5deg); }
}
.animate-float-slow {
    animation: float-slow 6s ease-in-out infinite;
}
</style>
@endsection
