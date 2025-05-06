@extends('layouts.app')

@section('content')
<style>
    /* Background floating animation */
    @keyframes floating {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-floating {
        animation-name: floating;
        animation-timing-function: ease-in-out;
        animation-iteration-count: infinite;
    }

    /* Slide and fade up animation */
    @keyframes slideFadeUp {
        0% { transform: translateY(40px); opacity: 0; }
        100% { transform: translateY(0); opacity: 1; }
    }
    .animate-slideFadeUp {
        animation: slideFadeUp 0.8s ease-out both;
    }
</style>

<div class="relative min-h-screen overflow-hidden py-10">

    {{-- Random decorative icons --}}
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

    {{-- Main content with animation --}}
    <div class="max-w-5xl mx-auto mt-10 px-6 relative z-10 animate-slideFadeUp">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">My Habits</h1>
            <a href="{{ route('habits.create') }}" 
               class="bg-white text-purple-700 font-semibold py-2 px-4 rounded-full border border-purple-500 shadow hover:bg-purple-100 hover:scale-105 transform transition-all duration-300">
                + Create Habit
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-purple-600 text-white">
                    <tr>
                        <th class="py-3 px-6 text-left">Title</th>
                        <th class="py-3 px-6 text-left">Category</th>
                        <th class="py-3 px-6 text-left">Schedule Type</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($habits as $habit)
                        <tr class="border-b">
                            <td class="py-4 px-6">{{ $habit->title }}</td>
                            <td class="py-4 px-6">{{ $habit->category->name ?? '-' }}</td>
                            <td class="py-4 px-6">{{ ucfirst($habit->schedule_type) ?? '-' }}</td>
                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('habits.edit', $habit) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-3 rounded mr-2 transition">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('habits.destroy', $habit) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure?')" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-3 rounded transition">
                                    🗑️ Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-gray-500">
                                No habits yet. Create your first habit!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
