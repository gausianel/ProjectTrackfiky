@extends('layouts.app')

@section('content')
<div class="relative flex justify-center items-center min-h-screen overflow-hidden">

{{-- Decorative Emojis --}}
<div class="absolute inset-0 pointer-events-none z-0">
    @for ($i = 0; $i < 16; $i++)
        <div 
            class="text-purple-200 opacity-30 absolute text-4xl"
            style="
                top: {{ rand(0, 90) }}%;
                left: {{ rand(0, 90) }}%;
                animation: floatY {{ rand(6, 14) }}s ease-in-out infinite, floatX {{ rand(8, 18) }}s ease-in-out infinite;
                animation-delay: {{ rand(0, 500) / 100 }}s;
            "
        >
            @php
                $icons = ['🏃‍♂️', '🚀', '🤸‍♀️', '🏋️‍♀️', '🎯', '🧗‍♂️', '✨'];
                echo $icons[array_rand($icons)];
            @endphp
        </div>
    @endfor
</div>



    {{-- Form Card --}}
    <div class="relative z-10 bg-white bg-opacity-90 backdrop-blur-md p-10 rounded-2xl shadow-2xl w-full max-w-md">
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

{{-- Animations --}}
<style>
    /* Vertical floating only (optional/legacy) */
    @keyframes floating {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-12px); }
    }
    .animate-floating {
        animation: floating 5s ease-in-out infinite;
    }
    
    /* Combined slide and fade-up for form content */
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
    
    /* Emoji movement animations */
    @keyframes floatY {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    @keyframes floatX {
        0%, 100% { transform: translateX(0px); }
        50% { transform: translateX(15px); }
    }
    </style>
  
    
@endsection
