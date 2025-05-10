@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen">
    <div class="bg-white p-10 rounded-2xl shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-purple-700 mb-6 text-center">Edit Category</h2>

        <form method="POST" action="{{ route('categories.update', $category->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-2 text-sm font-semibold text-gray-700">Category Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                    class="w-full px-4 py-2 border border-purple-300 rounded-md focus:ring-2 focus:ring-purple-400 focus:outline-none">
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('categories.create') }}" class="text-sm text-purple-600 hover:underline">Cancel</a>
                <button type="submit"
                    class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-full shadow-lg">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
