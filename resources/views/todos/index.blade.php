@extends('admin.layouts.adminlayout')

@section('content')
    <div class="flex-1 p-8">
        <h1 class="text-2xl font-bold text-gray-700 mb-4">Todo List</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Action Button -->
        <div class="flex justify-end mb-4">
            <a href="{{ route('todos.create') }}"
                class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">
                Create New Todo
            </a>
        </div>

        <!-- Todo Table -->
        <div class="bg-white shadow rounded-lg p-4">
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="p-3 border">ID</th>
                        <th class="p-3 border">Title</th>
                        <th class="p-3 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($todos as $todo)
                        <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
                            <td class="p-3 border text-center">{{ $todo->id }}</td>
                            <td class="p-3 border">{{ $todo->title }}</td>
                            <td class="p-3 border">
                                <div class="flex gap-2">
                                    <a href="{{ route('todos.edit', $todo->id) }}"
                                        class="bg-blue-500 text-white px-4 py-2 rounded flex-1 text-center hover:bg-blue-600 transition">
                                        Edit
                                    </a>

                                    <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 text-white px-4 py-2 rounded w-full text-center hover:bg-red-600 transition">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
