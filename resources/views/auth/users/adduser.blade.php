@extends('layout.app')

@section('content')
    <div class="flex-1 p-8">
        <h1 class="text-2xl font-bold text-gray-700 mb-4">Add New User</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('register') }}" method="POST">
                @csrf

                <!-- User Name -->
                <div class="mb-4">
                    <label class="block text-gray-700">User Name <span class="text-red-500">*</span></label>
                    <input type="text" name="username" value="{{ old('username') }}"
                        class="w-full p-2 border border-gray-300 rounded mt-1" required>
                    @error('username') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <!-- First Name -->
                <div class="mb-4">
                    <label class="block text-gray-700">First Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full p-2 border border-gray-300 rounded mt-1" required>
                    @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <!-- Last Name -->
                <div class="mb-4">
                    <label class="block text-gray-700">Last Name <span class="text-red-500">*</span></label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}"
                        class="w-full p-2 border border-gray-300 rounded mt-1" required>
                    @error('last_name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-700">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full p-2 border border-gray-300 rounded mt-1" required>
                    @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-gray-700">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password"
                        class="w-full p-2 border border-gray-300 rounded mt-1" required>
                    @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <!-- Password Confirmation -->
                <div class="mb-4">
                    <label class="block text-gray-700">Password Confirmation <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation"
                        class="w-full p-2 border border-gray-300 rounded mt-1" required>
                </div>

                <!-- Interface Locale -->
                {{-- <div class="mb-4">
                    <label class="block text-gray-700">Interface Locale</label>
                    <select name="locale" class="w-full p-2 border border-gray-300 rounded mt-1">
                        <option value="en_US" selected>English (United States)</option>
                        <option value="fr_FR">French (France)</option>
                    </select>
                </div> --}}

                <!-- Submit Button -->
                <div class="flex justify-between">
                    <a href="{{ route('admin.users') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Back
                    </a>
                    <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">
                        Save User
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
