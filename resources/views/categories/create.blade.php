@extends('layouts.app')

@section('content')
@php
    $routeName = Route::currentRouteName();
@endphp

{{-- ==== DECORATIVE ICONS (based on page) ==== --}}
<div class="absolute inset-0 pointer-events-none z-0">
    @for ($i = 0; $i < 10; $i++)
        <div 
            class="absolute text-6xl opacity-10 animate-floating"
            style="
                top: {{ rand(0, 95) }}%;
                left: {{ rand(0, 95) }}%;
                animation-delay: {{ rand(0, 400) / 100 }}s;
            ">
            @php
                $iconsWelcome = ['🌟', '📌', '🧠', '🕒', '⚡', '🎉', '📊', '💡'];
                $iconsHabit = ['🏃‍♂️', '🚀', '🤸‍♀️', '🏋️‍♀️', '🎯', '🎾', '🧗‍♂️', '✨'];
                $iconsCategory = ['📂', '🗂️', '🧱', '🧩', '🎨', '📁', '📋', '📝'];

                if ($routeName === 'habits.create') {
                    echo $iconsHabit[array_rand($iconsHabit)];
                } elseif ($routeName === 'categories.create') {
                    echo $iconsCategory[array_rand($iconsCategory)];
                } else {
                    echo $iconsWelcome[array_rand($iconsWelcome)];
                }
            @endphp
        </div>
    @endfor
</div>

{{-- ==== WELCOME ==== --}}
@if ($routeName === 'welcome')
<div class="relative flex items-center justify-center min-h-[calc(100vh-80px)] overflow-hidden">
    <div class="text-center text-white relative z-10">
        <h1 class="text-5xl font-bold mb-6 animate-fadeIn">Welcome to Trackfiky 🚀</h1>
        <p class="mb-8 text-xl">Manage your habits and logs easily!</p>

        <a href="{{ route('habits.index') }}" 
           class="bg-white text-purple-600 font-semibold py-3 px-6 rounded-full hover:bg-purple-100 transition-all duration-300">
            Go to Habits
        </a>
    </div>
</div>
@endif

{{-- ==== CREATE HABIT ==== --}}
@if ($routeName === 'habits.create')
<div class="flex justify-center items-center min-h-screen relative z-10">
    <div class="bg-white bg-opacity-90 backdrop-blur-md p-10 rounded-2xl shadow-2xl w-full max-w-md">
        <h2 class="text-3xl font-bold text-purple-700 mb-8 text-center animate-slideFadeUp">Create New Habit</h2>

        <form method="POST" action="{{ route('habits.store') }}" class="space-y-6 animate-slideFadeUp delay-150">
            @csrf

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Title</label>
                <input type="text" name="title" required
                    class="w-full px-4 py-2 border border-purple-300 rounded-md focus:ring-2 focus:ring-purple-400 focus:outline-none">
            </div>

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Category</label>
                <div class="flex gap-2">
                    <select name="category_id"
                        class="w-full px-4 py-2 border border-purple-300 rounded-md focus:ring-2 focus:ring-purple-400 focus:outline-none">
                        <option value="">-- None --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <a href="{{ route('categories.create') }}"
                        class="text-sm text-purple-600 font-semibold hover:underline whitespace-nowrap">+ New</a>
                </div>
            </div>

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Schedule Type</label>
                <select name="schedule_type" required
                    class="w-full px-4 py-2 border border-purple-300 rounded-md focus:ring-2 focus:ring-purple-400 focus:outline-none">
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                </select>
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('habits.index') }}" class="text-sm text-purple-600 hover:underline">Cancel</a>
                <button type="submit"
                    class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-full shadow-lg transition-all duration-300">
                    Create
                </button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- ==== CREATE CATEGORY ==== --}}
@if ($routeName === 'categories.create')
<div class="flex justify-center items-center min-h-screen relative z-10">
    <div class="bg-white bg-opacity-90 backdrop-blur-md p-10 rounded-2xl shadow-2xl w-full max-w-md">
        <h2 class="text-3xl font-bold text-purple-700 mb-8 text-center animate-slideFadeUp">Create New Category</h2>

        <form method="POST" action="{{ route('categories.store') }}" class="space-y-6 animate-slideFadeUp delay-150">
            @csrf

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Category Name</label>
                <input type="text" name="name" required
                    class="w-full px-4 py-2 border border-purple-300 rounded-md focus:ring-2 focus:ring-purple-400 focus:outline-none">
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('habits.create') }}" class="text-sm text-purple-600 hover:underline">Cancel</a>
                <button type="submit"
                    class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-full shadow-lg transition-all duration-300">
                    Create
                </button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- ==== ANIMATIONS ==== --}}
<style>
@keyframes floating {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-12px); }
}
.animate-floating {
    animation: floating 5s ease-in-out infinite;
}

@keyframes slideFadeUp {
    0% { transform: translateY(40px); opacity: 0; }
    100% { transform: translateY(0); opacity: 1; }
}
.animate-slideFadeUp {
    animation: slideFadeUp 1s ease-out both;
}
.delay-150 {
    animation-delay: 0.15s;
}
</style>
@endsection
