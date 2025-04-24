@extends('layouts.app')
@section('content')
<div class="container" x-data="{ open: false, publisher: {} }">
    <div class="flex justify-between py-8">
        <h2 class="text-2xl text-purple-700 font-semibold">📜 Publisher List</h2>
        <a href="{{ route('publishers.create') }}" class="bg-purple-900 text-white px-4 py-2 rounded hover:bg-purple-700">+ Add Publisher</a>
    </div>

    <!-- Search & Sort -->
    <div class="flex flex-wrap gap-4 mb-4 items-center justify-between">
        <form method="GET" action="{{ route('publishers.index') }}" class="flex flex-wrap gap-2">
            <input type="text" name="search" placeholder="Search name, email"
                   value="{{ request('search') }}"
                   class="p-2 border border-gray-300 rounded w-full sm:w-52" />

            <button type="submit" class="bg-purple-900 text-white px-4 py-2 rounded hover:bg-purple-700">Apply</button>

            @if(request('search'))
                <a href="{{ route('publishers.index') }}" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">Reset</a>
            @endif
        </form>

        <form method="GET" action="{{ route('publishers.index') }}" class="flex gap-2">
            <select name="sort" onchange="this.form.submit()" class="bg-gray-100 border border-gray-300 rounded px-3 py-2">
                <option disabled {{ !request()->has('sort') ? 'selected' : '' }}>Sort by</option>
                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                <option value="email" {{ request('sort') == 'email' ? 'selected' : '' }}>Email</option>
                
            </select>

            <select name="direction" onchange="this.form.submit()" class="bg-gray-100 border border-gray-300 rounded px-3 py-2">
                <option value="asc" {{ request('direction') === 'asc' ? 'selected' : '' }}>⬇️</option>
                <option value="desc" {{ request('direction') === 'desc' ? 'selected' : '' }}>⬆️</option>
            </select>
            @if(request('sort') || request('direction'))
    <a href="{{ route('publishers.index') }}" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">Reset</a>
@endif
        </form>
    </div>

    <!-- Publisher Table -->
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full table-auto text-sm">
            <thead class="bg-purple-900 text-white">
                <tr>
                    <th class="p-2 text-left">ID</th>
                    <th class="p-2 text-left">Name</th>
                    <th class="p-2 text-left">Email</th>
                  
                    <th class="p-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($publishers as $publisher)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-2">{{ $publisher->id }}</td>
                        <td class="p-2">{{ $publisher->name }}</td>
                        <td class="p-2">{{ $publisher->email }}</td>
            
                        <td class="p-2 flex gap-2">
                            <button
                                @click="open = true; publisher = {{ json_encode($publisher) }}"
                                class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700"
                            >
                                Edit
                            </button>

                            <form action="{{ route('publishers.destroy', $publisher->id) }}" method="POST" class="inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded delete-button">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
       
    </div>
    <div class="mt-4">
            {{ $publishers->links() }}
        </div>

    <!-- Edit Modal -->
    <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
         style="display: none;">
        <div @click.outside="open = false" class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-xl font-semibold mb-4 text-purple-700">✏️ Edit Publisher</h2>
            <form :action="`/publishers/${publisher.id}`" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="editing_id" :value="publisher.id">

                <div class="mb-4">
                    <label class="block text-sm font-medium">Name</label>
                    <input type="text" name="name" :value="publisher.name" class="w-full mt-1 p-2 border rounded" required>
                    @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
    <label class="block text-sm font-medium">✉️ Email</label>
    <input type="email" name="email" :value="publisher.email" class="w-full mt-1 p-2 border rounded" required>
    @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
</div>
                <div class="flex justify-end gap-2">
                <button type="submit" class="px-4 py-2 bg-purple-900 text-white rounded hover:bg-purple-700">Update</button>
                    <button type="button" @click="open = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="//unpkg.com/alpinejs" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function () {
            Swal.fire({
                title: 'Are you sure you want to delete this publisher?',
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

@if($errors->any() && old('editing_id'))
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const event = new CustomEvent('open-edit', {
            detail: {
                publisher: {
                    id: '{{ old('editing_id') }}',
                    name: '{{ old('name') }}',
                    email: '{{ old('email') }}',
                    
                }
            }
        });
        window.dispatchEvent(event);
    });
</script>
@endif
@endsection
