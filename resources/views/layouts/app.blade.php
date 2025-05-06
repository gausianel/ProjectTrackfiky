<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trackfiky</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes rocketFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }

        .animate-rocket {
            animation: rocketFloat 2s ease-in-out infinite;
            display: inline-block;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-500 via-purple-600 to-indigo-700 min-h-screen font-sans">

  {{-- Navbar --}}
  <nav class="bg-white/20 backdrop-blur-md shadow-lg sticky top-0 z-50 px-6 md:px-10 py-6 flex justify-between items-center rounded-b-2xl mx-4 mt-4">
    {{-- Logo --}}
    <div class="text-2xl font-extrabold text-white tracking-wide">
        <a href="{{ route('dashboard') }}" class="hover:scale-105 transition-transform duration-200">
            <span class="animate-rocket">🚀</span> Trackfiky
        </a>
    </div>

    {{-- Navigation Links --}}
    <div class="hidden md:flex items-center space-x-6">
        @php
            $navItems = [
                ['name' => 'Dashboard', 'route' => 'dashboard'],
                ['name' => 'Habits', 'route' => 'habits.index'],
                ['name' => 'Logs', 'route' => 'logs.index'],
                ['name' => 'Guide', 'route' => 'guide'],
            ];
        @endphp

        @foreach ($navItems as $item)
            <a href="{{ route($item['route']) }}"
               class="relative text-white font-medium transition-all duration-300 hover:text-purple-100 hover:scale-105 group">
                {{ $item['name'] }}
                <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-white transition-all group-hover:w-full"></span>
            </a>
        @endforeach

        {{-- Logout Button --}}
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit"
                    class="relative text-red-200 font-semibold transition-all duration-300 hover:text-red-400 hover:scale-105 group">
                Logout
                <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-red-300 transition-all group-hover:w-full"></span>
            </button>
        </form>
    </div>
</nav>

{{-- Flash Message --}}
@if (session('success'))
    <div class="bg-green-500 text-white text-center py-3 rounded-md mx-6 my-4 shadow-md">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="bg-red-500 text-white text-center py-3 rounded-md mx-6 my-4 shadow-md">
        {{ session('error') }}
    </div>
@endif

{{-- Content --}}
<main class="px-6 py-10">
    @yield('content')
</main>

</body>
</html>
