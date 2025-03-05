@extends('admin.layouts.adminlayout')
<!-- Main Content -->

@section('content')
    <div class="flex-1 p-8">

        <h1 class="text-2xl font-bold text-gray-700 mb-4">Roles</h1>
        <div>
            <!-- Table -->
            @if (session('success'))
                <div class="bg-green-500 text-white p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
        </div>
        <!-- Action Buttons -->
        <div class="flex justify-end mb-4">
            <a href="{{ route('admin.createRole') }}"
                class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">
                Add New Role
            </a>
        </div>

        <!-- Table -->
        <div class="bg-white shadow rounded-lg p-4">
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="p-3 border">ID</th>
                        <th class="p-3 border">Role</th>
                        <th class="p-3 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
                            <td class="p-3 border text-center">{{ $role->id }}</td>
                            <td class="p-3 border text-center">{{ $role->name }}</td>
                            <td class="p-3 border">
                                <div class="flex gap-2 w-full"> 
                                    <a href="{{ route('role.edit', $role->id) }}"  
                                       class="bg-blue-500 text-white px-4 py-2 rounded flex-1 text-center hover:bg-blue-600 transition">
                                       Edit
                                    </a>
                            
                                    <form action="{{ route('roles.delete', $role->id) }}" method="post" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"  
                                                class="bg-red-500 text-white px-4 py-2 rounded w-full text-center hover:bg-red-600 transition"
                                                onclick="return confirm('Are you sure you want to delete this role?')">
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
