@extends('layouts.app')

@section('content')
<div class="container mx-auto ">
    <div class="flex justify-between items-center py-8">
        <h2 class="text-2xl font-bold text-purple-800">🖨️ Add New Publisher</h2>
        <a href="{{ route('publishers.index') }}" class="text-sm bg-purple-900 hover:bg-purple-700 transition-colors text-white px-4 py-2 rounded shadow-md">← Back</a>
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

    <form method="POST" action="{{ route('publishers.store') }}" class="bg-white shadow-lg rounded-lg p-6 space-y-5">
        @csrf

        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">🏷️ Publisher Name</label>
            <input type="text" name="name" id="name"
                   class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-purple-600 transition"
                   value="{{ old('name') }}" required>
        </div>

        <div>
  <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">📧 Email</label>
  <input type="email" name="email" id="email"
         class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-purple-600 transition"
         value="{{ old('email') }}">
</div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-purple-800 hover:bg-purple-700 text-white font-semibold py-3 rounded-lg transition shadow-lg">
                ➕ Add Publisher
            </button>
        </div>
    </form>
</div>
@endsection
