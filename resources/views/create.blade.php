@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center py-8">
        <h2 class="text-2xl font-bold text-purple-800">📚 Add New Book</h2>
        <a href="/" class="text-sm bg-purple-900 hover:bg-purple-700 transition-colors text-white px-4 py-2 rounded shadow-md">← Back</a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6 shadow">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('store') }}" class="bg-white shadow-lg rounded-lg p-6 space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">📖 Title</label>
            <input type="text" name="title" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-purple-600 transition" value="{{ old('title') }}" required>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">✍️ Author</label>
            <input type="text" name="author" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-purple-600 transition" value="{{ old('author') }}" required>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">📅 Published Year</label>
            <input type="number" name="published_year" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-purple-600 transition" value="{{ old('published_year') }}">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">🏢 Publisher</label>
            <select name="publisher_id" class="w-full border border-gray-300 rounded-lg p-3 bg-white focus:outline-none focus:ring-2 focus:ring-purple-600 transition">
                <option value="">-- Select Publisher --</option>
                @foreach($publishers as $publisher)
                    <option value="{{ $publisher->id }}" {{ old('publisher_id', $book->publisher_id ?? '') == $publisher->id ? 'selected' : '' }}>
                        {{ $publisher->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">🎭 Genre</label>
            <input type="text" name="genre" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-purple-600 transition" value="{{ old('genre') }}">
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-purple-800 hover:bg-purple-700 text-white font-semibold py-3 rounded-lg transition shadow-lg">
                ➕ Add Book
            </button>
        </div>
    </form>
</div>
@endsection
