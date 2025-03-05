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

        <!-- Form Container -->
        <div class="bg-white shadow-md rounded-lg p-6">
        
           

            <!-- User Registration Form -->
            <form action="{{ route('agent.adduser') }}" method="POST">
                @csrf

                <!-- Tab Content -->
                <div id="user-info" class="tab-content">
                    <!-- User Name -->
                    <div class="mb-4">
                        <label class="block text-gray-700">User Name <span class="text-red-500">*</span></label>
                        <input type="text" name="username" value="{{ old('username') }}" class="w-full p-2 border border-gray-300 rounded mt-1" required>
                        @error('username') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <!-- First Name -->
                    <div class="mb-4">
                        <label class="block text-gray-700">First Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full p-2 border border-gray-300 rounded mt-1" required>
                        @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <!-- Last Name -->
                    <div class="mb-4">
                        <label class="block text-gray-700">Last Name <span class="text-red-500">*</span></label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" class="w-full p-2 border border-gray-300 rounded mt-1" required>
                        @error('last_name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label class="block text-gray-700">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full p-2 border border-gray-300 rounded mt-1" required>
                        @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label class="block text-gray-700">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" class="w-full p-2 border border-gray-300 rounded mt-1" required>
                        @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div class="mb-4">
                        <label class="block text-gray-700">Confirm Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" class="w-full p-2 border border-gray-300 rounded mt-1" required>
                    </div>
                </div>

                <!-- User Role Tab -->
                <div id="user-role" class="tab-content ">
                    <div class="mb-4">
                        <label class="block text-gray-700">Select Role <span class="text-red-500">*</span></label>
                        <select name="role_id" class="w-full p-2 border border-gray-300 rounded mt-1" required>
                            <option value="">-- Select Role --</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Submit & Back Buttons -->
                <div class="flex justify-between mt-4">
                    <a href="{{ route('agent.userlist') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
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
