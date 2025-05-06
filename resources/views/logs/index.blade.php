@extends('layouts.app')

@section('content')
<style>
    @keyframes floating {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-floating {
        animation-name: floating;
        animation-timing-function: ease-in-out;
        animation-iteration-count: infinite;
    }

    @keyframes slideFadeUp {
        0% { transform: translateY(40px); opacity: 0; }
        100% { transform: translateY(0); opacity: 1; }
    }
    .animate-slideFadeUp {
        animation: slideFadeUp 0.8s ease-out both;
    }
</style>

<div class="relative min-h-screen overflow-hidden py-10">

    {{-- Background Icons --}}
    <div class="absolute inset-0 z-0 pointer-events-none">
        @for ($i = 0; $i < 30; $i++)
            <div 
                class="text-white opacity-10 absolute text-4xl animate-floating"
                style="
                    top: {{ rand(0, 95) }}%;
                    left: {{ rand(0, 95) }}%;
                    transform: rotate({{ rand(0, 360) }}deg);
                    animation-delay: {{ rand(0, 300) / 100 }}s;
                    animation-duration: {{ rand(2, 3) }}s;
                "
            >
                @php
                    $icons = ['⭐', '✅', '📅', '🔥', '💪', '🎯', '📈', '🚀'];
                    echo $icons[array_rand($icons)];
                @endphp
            </div>
        @endfor
    </div>

    {{-- Content --}}
    <div class="max-w-5xl mx-auto mt-10 px-6 relative z-10 animate-slideFadeUp">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">My Habit Logs</h1>
            <a href="{{ route('logs.create') }}" 
               class="bg-white text-purple-700 font-semibold py-2 px-4 rounded-full border border-purple-500 shadow hover:bg-purple-100 hover:scale-105 transform transition-all duration-300">
                + Add Log
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-x-auto">
            @if($logs->isEmpty())
                <p class="text-center text-gray-500 py-6 text-lg">No logs yet. Start logging your habits! 📒</p>
            @else
            <table class="min-w-full">
                <thead class="bg-purple-600 text-white">
                    <tr>
                        <th class="py-3 px-6 text-left">Habit</th>
                        <th class="py-3 px-6 text-left">Date</th>
                        <th class="py-3 px-6 text-left">Time</th>
                        <th class="py-3 px-6 text-left">Note</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($logs as $log)
                    <tr class="border-b">
                        <td class="py-4 px-6 font-medium">{{ $log->habit->title }}</td>
                        <td class="py-4 px-6">{{ $log->date }}</td>
                        <td class="py-4 px-6">{{ $log->time_checked ?? '-' }}</td>
                        <td class="py-4 px-6">{{ $log->note ?? '-' }}</td>
                        <td class="py-4 px-6 text-center">
                            <a href="{{ route('logs.edit', $log->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-3 rounded mr-2 transition">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('logs.destroy', $log->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-3 rounded transition">
                                    🗑️ Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>
@endsection
