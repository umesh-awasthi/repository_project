@extends('admin.layouts.adminlayout')

@section('content')
    <div class="flex-1 p-8">
        <h2 class="text-2xl font-bold text-gray-700 mb-4">Settings</h2>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Manage Permissions & Roles</h3>
            <div class="flex gap-4">
                <a href="{{ route('admin.index') }}" 
                   class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                    Assign Role Permissions
                </a>
                <a href="{{ route('admin.createPermission') }}" 
                   class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                    Create New Permission
                </a>
                <a href="{{ url('/admin/viewpermissions') }}" 
                   class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                    View Permissions
                </a>
            </div>
        </div>
    </div>
@endsection
