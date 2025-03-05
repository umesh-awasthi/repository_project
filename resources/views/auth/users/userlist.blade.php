@extends('layout.app')

@section('content')
    <div class="flex-1 p-8">
        <h1 class="text-2xl font-bold text-gray-700 mb-4">User List</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex justify-end mb-4">
            @if (in_array('create_user', $permissions))
                <a href="{{ route('agent.registeruser') }}"
                    class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">
                    Add New User
                </a>
            @endif

        </div>

        <!-- Table -->
        <div class="bg-white shadow rounded-lg p-4">
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="p-3 border">ID</th>
                        <th class="p-3 border">Name</th>
                        <th class="p-3 border">Email</th>
                        <th class="p-3 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
                            <td class="p-3 border">{{ $user->id }}</td>
                            <td class="p-3 border">{{ $user->name }}</td>
                            <td class="p-3 border">{{ $user->email }}</td>
                            <td class="p-3 border">
                                <div class="flex gap-2">
                                    @if (in_array('edit_user', $permissions))
                                        <a href="{{ route('agent.edituser', $user->id) }}"
                                            class="bg-blue-500 text-white px-4 py-2 rounded w-full text-center hover:bg-blue-600 transition">
                                            Edit
                                        </a>
                                    @endif
                                    @if (in_array('delete_user', $permissions))
                                        <form action="{{ route('agent.deleteuser', $user->id) }}" method="POST"
                                            class="w-full">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 text-white px-4 py-2 rounded w-full text-center hover:bg-red-600 transition"
                                                onclick="return confirm('Are you sure?')">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
