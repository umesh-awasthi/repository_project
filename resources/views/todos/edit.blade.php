@extends('admin.layouts.adminlayout')

@section('content')
    <div class="flex-1 p-8">
        <h1 class="text-2xl font-bold text-gray-700 mb-4">Edit Todo</h1>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="bg-red-500 text-white p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Edit Todo Form -->
        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('todos.update', $todo->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" id="title" name="title" value="{{ $todo->title }}" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300">
                </div>

                <div class="flex gap-4">
                    <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                        Update Todo
                    </button>

                    <a href="{{ route('todos.list') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                        Back to Todo List
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
