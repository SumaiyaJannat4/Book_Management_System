<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('content')

<!-- ✅ Main Content -->
<div class="container">
    <!-- Top Controls -->
    <div class="flex justify-between py-8">
        <h2 class="text-2xl text-purple-700 font-semibold">📋Book List</h2>
        <a href="/create" class="bg-purple-900 text-white px-4 py-2 rounded hover:bg-purple-700">+ Add Book</a>
    </div>

    <!-- Search & Sort -->
    <div class="flex gap-4 mb-4 items-center justify-between x-cloak">
        <form method="GET" action="{{ route('books.index') }}" class="flex flex-wrap gap-2">
            
                <input type="text" name="search" placeholder="Search title, author, year, genre, publisher"
       value="{{ request('search') }}"
       class="p-2 border border-gray-300 rounded w-full sm:w-80 md:w-92" />

            <button type="submit" class="bg-purple-900 text-white px-4 py-2 rounded hover:bg-purple-700">
                Apply
            </button>

            @if(request('search'))
            <a href="{{ route('books.index') }}" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">
                Reset
            </a>
            @endif
        </form>

        <!-- Sort -->
        <form method="GET" action="{{ route('books.index') }}" class="flex gap-2">
            <select name="sort" onchange="this.form.submit()"
                    class="bg-gray-100 border border-gray-300 rounded px-3 py-2">
                <option disabled {{ !request()->has('sort') ? 'selected' : '' }}>Sort by</option>
                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title</option>
                <option value="author" {{ request('sort') == 'author' ? 'selected' : '' }}>Author</option>
                <option value="published_year" {{ request('sort') == 'published_year' ? 'selected' : '' }}>Year</option>
                <option value="genre" {{ request('sort') == 'genre' ? 'selected' : '' }}>Genre</option>
            </select>

            <select name="direction" onchange="this.form.submit()"
                    class="bg-gray-100 border border-gray-300 rounded px-3 py-2">
                <option value="asc" {{ request('direction') === 'asc' ? 'selected' : '' }}>⬇️</option>
                <option value="desc" {{ request('direction') === 'desc' ? 'selected' : '' }}>⬆️</option>
            </select>

            @if(request('sort') || request('direction'))
            <a href="{{ route('books.index') }}" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">Reset</a>
            @endif
        </form>
    </div>

    <!-- Book Table -->
    <div class="overflow-x-auto bg-white rounded shadow">
        @php
        $oldBook = old();
        $hasErrors = $errors->any() && session('editing_book_id');
        $editingBook = session('editing_book_data');
        if ($hasErrors && $editingBook) {
            $oldBook['id'] = $editingBook->id; // attach the ID to old input
        }
        @endphp

        <div 
        x-data="{ editOpen: false, editBook: null }"
        x-init="
            @if($hasErrors && $editingBook)
                editOpen = true;
                editBook = {{ json_encode($oldBook) }};
            @endif
        ">
            <table class="min-w-full table-auto text-sm">
                <thead class="bg-purple-900 text-white">
                    <tr>
                        <th class="p-2 text-left">ID</th>
                        <th class="p-2 text-left">Title</th>
                        <th class="p-2 text-left">Author</th>
                        <th class="p-2 text-left">Year</th>
                        <th class="p-2 text-left">Genre</th>
                        <th class="p-2 text-left">Publisher</th>
                        <th class="p-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $book)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-2">{{ $book->id }}</td>
                        <td class="p-2">{{ $book->title }}</td>
                        <td class="p-2">{{ $book->author }}</td>
                        <td class="p-2">{{ $book->published_year }}</td>
                        <td class="p-2">{{ $book->genre }}</td>
                        <td class="p-2">{{ $book->publisher?->name ?? 'N/A' }}</td>
                        <td class="p-2 flex gap-2">
                            <button @click="editOpen = true; editBook = {{ $book->toJson() }}"
                                class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                Edit
                            </button>

                            <form action="{{ route('destroy', $book->id) }}" method="POST" class="inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded delete-button">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- 📝 Edit Form Modal -->
            <div x-show="editOpen" x-cloak
                class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
                <div @click.away="editOpen = false"
                    class="bg-white p-6 rounded-md w-full max-w-xl shadow-xl relative">

                    <h2 class="text-xl font-bold text-purple-700 mb-4">📝Edit Book</h2>
                    @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" :action="'/update/' + editBook.id">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block font-medium">Title</label>
                            <input type="text" name="title" x-model="editBook.title"
                                class="w-full border rounded p-2">
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium">Author</label>
                            <input type="text" name="author" x-model="editBook.author"
                                class="w-full border rounded p-2">
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium">Published Year</label>
                            <input type="number" name="published_year" x-model="editBook.published_year"
                                class="w-full border rounded p-2">
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium">Publisher</label>
                            <select name="publisher_id"
                                    x-model="editBook.publisher_id"
                                    class="w-full border rounded p-2">
                                <option value="">-- Select Publisher --</option>
                                @foreach($publishers as $publisher)
                                <option value="{{ $publisher->id }}" 
                                        :selected="editBook.publisher_id == {{ $publisher->id }} ? true : false">
                                    {{ $publisher->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium">Genre</label>
                            <input type="text" name="genre" x-model="editBook.genre"
                                class="w-full border rounded p-2">
                        </div>

                        <div class="flex justify-end gap-2 mt-6">
                            <button type="submit"
                                class="bg-purple-900 text-white px-4 py-2 rounded hover:bg-purple-700">
                                Save
                            </button>
                            <button type="button" @click="editOpen = false"
                                class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
        <div class="mt-4">
            {{ $books->links() }}
        </div>
</div>

<script>
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function () {
            Swal.fire({
                title: 'Are you sure you want to delete this book?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#581c87',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.closest('form').submit();
                }
            });
        });
    });
</script>

@endsection
