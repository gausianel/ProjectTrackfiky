@extends('layouts.app')

@section('content')
<style>
    @keyframes floatIcon {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-12px); }
    }

    @keyframes slideUpFade {
        0% { transform: translateY(40px); opacity: 0; }
        100% { transform: translateY(0); opacity: 1; }
    }

    .animate-float {
        animation: floatIcon 3s ease-in-out infinite;
    }

    .animate-slideUpFade {
        animation: slideUpFade 1s ease-out both;
    }
</style>

<div class="relative flex flex-col items-center justify-center min-h-[130vh] pt-20 pb-32 overflow-hidden">

    {{-- Floating Emoji Background --}}
    <div class="absolute inset-0 pointer-events-none z-0">
        @for ($i = 0; $i < 20; $i++)
            <div class="text-indigo-200 opacity-30 absolute text-5xl animate-float"
                style="
                    top: {{ rand(0, 90) }}%;
                    left: {{ rand(0, 90) }}%;
                    animation-delay: {{ rand(0, 500) / 100 }}s;
                ">
                @php
                    $icons = ['📘', '🧾', '📌', '🕒', '✅', '🧠', '🔄'];
                    echo $icons[array_rand($icons)];
                @endphp
            </div>
        @endfor
    </div>

    {{-- Content Card --}}
    <div class="relative z-10 bg-white bg-opacity-90 backdrop-blur-xl rounded-2xl shadow-2xl p-8 w-full max-w-3xl animate-slideUpFade">
        <h1 class="text-3xl font-bold text-purple-700 mb-6 text-center">Panduan Penggunaan Trackfiky 📘</h1>

        <div class="space-y-6 text-gray-700 text-base">
            <div>
                <h2 class="text-xl font-semibold text-purple-600">1. Apa itu Trackfiky?</h2>
                <p>Trackfiky adalah aplikasi untuk mencatat dan memantau kebiasaan harian kamu secara praktis dan efisien.</p>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-purple-600">2. Cara Menambahkan Habit</h2>
                <p>Klik tombol <strong>“Create Habit”</strong> di halaman Habits, lalu isi judul, kategori, dan tipe jadwal (harian atau mingguan).</p>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-purple-600">3. Mencatat Log Harian</h2>
                <p>Buka halaman Logs, klik “Create Log”, pilih habit yang sudah dibuat, isi waktu & catatan jika ada, lalu simpan.</p>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-purple-600">4. Mengedit atau Menghapus</h2>
                <p>Kamu bisa mengedit atau menghapus Habit dan Log dari halaman daftar dengan tombol ✏️ Edit atau 🗑️ Delete.</p>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-purple-600">5. Tips Penggunaan</h2>
                <ul class="list-disc ml-5">
                    <li>✅ Update log harian secara konsisten setiap hari.</li>
                    <li>📌 Gunakan kategori untuk mengelompokkan habit kamu.</li>
                    <li>🔄 Jangan ragu edit habit jika ingin ubah jadwal.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
