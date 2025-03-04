@extends('admin.layouts.adminlayout')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Create Permission</h1>
        <form action="{{ route('admin.createPermission') }}" method="POST" class="bg-white p-6 rounded shadow-md">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Permission Name:</label>
                <input type="text" name="name" id="name" required 
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" 
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                Create Permission
            </button>
        </form>
    </div>
@endsection
