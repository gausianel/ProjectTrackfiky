@extends('layouts.app')

@section('content')
<div class="relative flex items-center justify-center min-h-[calc(100vh-80px)] overflow-hidden">

    {{-- Decorative Floating Icons --}}
    <div class="absolute inset-0 z-0 pointer-events-none">
        @for ($i = 0; $i < 30; $i++)
            <div 
                class="text-white opacity-15 absolute text-5xl animate-floating"
                style="
                    top: {{ rand(0, 95) }}%;
                    left: {{ rand(0, 95) }}%;
                    animation-delay: {{ rand(0, 500) / 100 }}s;
                "
            >
                @php
                    $icons = ['🌟', '📌', '🧠', '🕒', '⚡', '🎉', '📊', '💡'];
                    echo $icons[array_rand($icons)];
                @endphp
            </div>
        @endfor
    </div>

    {{-- Main Welcome Content --}}
    <div class="text-center text-white relative z-10 animate-slideFadeUp">
        <h1 class="text-5xl font-bold mb-6 animate-floating">🚀</h1>
        <h1 class="text-5xl font-bold mb-6"> Welcome to Trackfiky</h1>
        <p class="mb-8 text-xl">Manage your habits and logs easily!</p>

        <a href="{{ route('habits.index') }}" 
           class="bg-white text-purple-600 font-semibold py-3 px-6 rounded-full hover:bg-purple-100 transition-all duration-300 shadow-md animate-slideFadeUp">
            Go to Habits
        </a>
    </div>
</div>

{{-- Animations --}}
<style>
    @keyframes floating {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-floating {
        animation: floating 3s ease-in-out infinite; /* 💨 Percepat jadi 3 detik */
    }
    
    @keyframes slideFadeUp {
        0% { transform: translateY(30px); opacity: 0; }
        100% { transform: translateY(0); opacity: 1; }
    }
    .animate-slideFadeUp {
        animation: slideFadeUp 1s ease-out both;
    }

    
    </style>
    
@endsection
