@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl w-full space-y-6 bg-white p-8 rounded-xl shadow-xl">

        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-purple-700">Your Categories</h2>
            <a href="{{ route('categories.create') }}"
               class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-full text-sm transition">
               + Add Category
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        @if ($categories->count())
            <ul class="divide-y divide-purple-200">
                @foreach ($categories as $category)
                    <li class="py-3 flex justify-between items-center">
                        <span class="font-medium text-gray-800">{{ $category->name }}</span>
                        <div class="flex gap-2">
                            <a href="{{ route('categories.edit', $category->id) }}" class="text-blue-600 text-sm hover:underline">Edit</a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are
