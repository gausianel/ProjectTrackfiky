@extends('layouts.app')

@section('content')
<style>
    body {
        background-image: url('/storage/bg-pattern.png');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }

    @keyframes floatY2 {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }
    @keyframes floatX2 {
        0%, 100% { transform: translateX(0); }
        50% { transform: translateX(12px); }
    }
    @keyframes slideFadeUp {
        0% { transform: translateY(40px); opacity: 0; }
        100% { transform: translateY(0); opacity: 1; }
    }
    .animate-slideFadeUp {
        animation: slideFadeUp 0.8s ease-out both;
    }
</style>

<div class="relative flex items-center justify-center min-h-[calc(100vh-80px)] overflow-hidden">

    {{-- Floating Icons --}}
    <div class="absolute inset-0 pointer-events-none z-0">
        @for ($i = 0; $i < 20; $i++)
            <div 
                class="text-yellow-200 opacity-30 absolute text-3xl"
                style="
                    top: {{ rand(0, 95) }}%;
                    left: {{ rand(0, 95) }}%;
                    animation: floatY2 {{ rand(6, 14) }}s ease-in-out infinite, floatX2 {{ rand(8, 18) }}s ease-in-out infinite;
                    animation-delay: {{ rand(0, 500) / 100 }}s;
                "
            >
                @php
                    $icons = ['📒', '🕒', '🧠', '🔁', '✅', '📋', '📊'];
                    echo $icons[array_rand($icons)];
                @endphp
            </div>
        @endfor
    </div>

    {{-- Form Card --}}
    <div class="relative z-10 bg-white bg-opacity-90 backdrop-blur-lg p-8 rounded-2xl shadow-2xl w-full max-w-lg animate-slideFadeUp">
        <h2 class="text-3xl font-bold mb-6 text-purple-700 text-center">Edit Habit Log</h2>

        <form method="POST" action="{{ route('logs.update', $log->id) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Habit</label>
                <input type="text" value="{{ $log->habit->title }}" disabled
                    class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md cursor-not-allowed">
            </div>

            <div>
                <label for="time_checked" class="block mb-2 text-sm font-semibold text-gray-700">Time Checked</label>
                <input type="time" name="time_checked" id="time_checked"
                    value="{{ old('time_checked', $log->time_checked ? \Carbon\Carbon::parse($log->time_checked)->format('H:i') : '') }}"
                    class="w-full px-4 py-2 border border-purple-300 rounded-md focus:ring-2 focus:ring-purple-400 focus:outline-none">
                @error('time_checked')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="note" class="block mb-2 text-sm font-semibold text-gray-700">Note (Optional)</label>
                <textarea name="note" id="note" rows="3"
                    class="w-full px-4 py-2 border border-purple-300 rounded-md focus:ring-2 focus:ring-purple-400 focus:outline-none resize-none"
                    placeholder="Add any notes...">{{ old('note', $log->note) }}</textarea>
                @error('note')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center pt-4">
                <a href="{{ route('logs.index') }}" class="text-sm text-purple-600 hover:underline">Cancel</a>
                <button type="submit"
                    class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-full shadow-lg transition-all duration-300">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
