@extends('layouts.app')

@section('content')
<div class="relative flex items-center justify-center min-h-[calc(100vh-80px)] overflow-hidden">

    {{-- Decorative Emojis --}}
    <div class="absolute inset-0 pointer-events-none z-0">
        @for ($i = 0; $i < 18; $i++)
            <div 
                class="text-purple-300 opacity-30 absolute text-3xl"
                style="
                    top: {{ rand(0, 95) }}%;
                    left: {{ rand(0, 95) }}%;
                    animation: floatXY {{ rand(10, 20) }}s ease-in-out infinite;
                    animation-delay: {{ rand(0, 1000) / 100 }}s;
                "
            >
                @php
                    $icons = ['✅', '💪', '📆', '⏰', '🏅', '🎯', '🌟', '📝', '📈'];
                    echo $icons[array_rand($icons)];
                @endphp
            </div>
        @endfor
    </div>

    {{-- Form Card --}}
    <div class="relative z-10 bg-white bg-opacity-90 backdrop-blur-md p-8 rounded-2xl shadow-xl w-full max-w-md animate-slideFadeUp">
        <h2 class="text-2xl font-bold mb-6 text-purple-700 text-center">Add Habit Log</h2>

        <form method="POST" action="{{ route('logs.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block mb-2 text-sm font-bold text-gray-700">Habit</label>
                <select name="habit_id" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-purple-500">
                    @foreach ($habits as $habit)
                        <option value="{{ $habit->id }}">{{ $habit->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-2 text-sm font-bold text-gray-700">Time Checked (optional)</label>
                <input type="time" name="time_checked" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-purple-500">
            </div>

            <div class="mb-6">
                <label class="block mb-2 text-sm font-bold text-gray-700">Note</label>
                <textarea name="note" rows="3" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-purple-500" placeholder="Optional note..."></textarea>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('logs.index') }}" class="text-purple-500 hover:underline">Cancel</a>
                <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">Save Log</button>
            </div>
        </form>
    </div>
</div>

{{-- Animations --}}
<style>
    @keyframes slideFadeUp {
        0% { transform: translateY(40px); opacity: 0; }
        100% { transform: translateY(0); opacity: 1; }
    }
    .animate-slideFadeUp {
        animation: slideFadeUp 1s ease-out both;
    }

    @keyframes floatXY {
        0%, 100% { transform: translate(0, 0); }
        25% { transform: translate(-10px, -5px); }
        50% { transform: translate(5px, 10px); }
        75% { transform: translate(-5px, 5px); }
    }
</style>
@endsection
