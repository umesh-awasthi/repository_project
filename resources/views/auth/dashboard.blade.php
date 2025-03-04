@extends('layout.app')

@section('content')
    <div class="flex-1 p-8">
        <h1 class="text-2xl font-bold text-gray-700 mb-4">Dashboard</h1>
     
        <p class="text-gray-600">Welcome to the dashboard!</p>
        @if(isset($permissions) && count($permissions) > 0)
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Your Permissions</h2>
            <ul class="list-disc pl-5">
                @foreach($permissions as $permission)
                    <li class="text-gray-600">{{ $permission->name }}</li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-600">You do not have any permissions assigned.</p>
        @endif

        <!-- Add more dashboard content here -->
        <div class="bg-white shadow rounded-lg p-6 mt-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Quick Actions</h2>
            <div class="flex gap-4">
                <a href="{{ route('todos.list') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                    Todos
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
