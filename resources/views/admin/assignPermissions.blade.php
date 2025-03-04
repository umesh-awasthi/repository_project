@extends('admin.layouts.adminlayout')

@section('content')
    <div class="flex-1 p-8">
        <h2 class="text-2xl font-bold text-gray-700 mb-4">Assign Permissions to Role</h2>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('admin.assignPermission') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="role_id" class="block text-sm font-medium text-gray-700">Select Role</label>
                    <select name="role_id" id="role_id"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Select Permissions</label>
                    <div class="bg-gray-100 p-3 rounded-lg shadow-sm">
                        @foreach ($permissions as $permission)
                            <div class="flex items-center mb-2">
                                <input type="checkbox" name="permission_id[]" value="{{ $permission->id }}" 
                                    class="mr-2 accent-blue-500">
                                <label class="text-sm text-gray-600">{{ $permission->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit" 
                    class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                    Assign Permissions
                </button>
            </form>
        </div>
    </div>
@endsection
