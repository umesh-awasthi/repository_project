@extends('admin.layouts.adminlayout')

@section('content')
<div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Edit Role</h2>

    <!-- Form -->
    <form action="{{ route('role.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Role Name Input -->
        <label for="name" class="block font-semibold">Role Name:</label>
        <input type="text" name="name" id="name" 
               class="w-full p-2 border rounded mt-1" 
               value="{{ old('name', $role->name) }}" required>

        <!-- Validation Error -->
        @error('name')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror

        <!-- Submit Button -->
        <button type="submit" 
                class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
            Update Role
        </button>
    </form>
</div>
@endsection
