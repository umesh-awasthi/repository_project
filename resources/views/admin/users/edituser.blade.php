@extends('admin.layouts.adminlayout')

@section('content')
<div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Edit User</h2>

    <!-- Form -->
    <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- User Name Input -->
        <label for="name" class="block font-semibold">User Name:</label>
        <input type="text" name="name" id="name" 
               class="w-full p-2 border rounded mt-1" 
               value="{{ old('name', $user->name) }}" required>

        <!-- Email Input -->
        <label for="email" class="block font-semibold mt-3">Email:</label>
        <input type="email" name="email" id="email" 
               class="w-full p-2 border rounded mt-1" 
               value="{{ old('email', $user->email) }}" required>

        <!-- Role Dropdown -->
        <label for="role_id" class="block font-semibold mt-3">User Role:</label>
        <select name="role_id" id="role_id" class="w-full p-2 border rounded mt-1">
            <option value="">-- Select Role --</option>
            @foreach ($roles as $role)
                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>

        <!-- Validation Errors -->
        @error('name')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
        @error('role_id')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror

        <!-- Submit Button -->
        <button type="submit" 
                class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition w-full">
            Update User
        </button>
    </form>
</div>
@endsection
