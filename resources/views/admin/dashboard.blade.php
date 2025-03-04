@extends('admin.layouts.adminlayout')

@section('content')
    <div class="flex-1 p-8">
        <h1 class="text-2xl font-bold text-gray-700 mb-4">Dashboard</h1>
        <p class="text-gray-600">Welcome to the admin dashboard!</p>

        <!-- Add more dashboard content here -->
        <div class="bg-white shadow rounded-lg p-6 mt-6">
            {{-- <h2 class="text-xl font-semibold text-gray-700 mb-4">Your Permissions</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-6">
                @foreach ($permissions as $permission)
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <span class="text-sm text-gray-700">{{ $permission }}</span>
                    </div>
                @endforeach
            </div> --}}
            
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Quick Actions</h2>
            <div class="flex gap-4">
                <a href="{{ route('admin.createRole') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                    Add New Role
                </a>
                <a href="{{ route('admin.createPermission') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                    Create New Permission
                </a>
                <a href="{{ route('admin.index') }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">
                    Manage Roles & Permissions
                </a>
            </div>
        </div>
    </div>
@endsection
