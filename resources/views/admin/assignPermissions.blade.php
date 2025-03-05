{{-- @extends('admin.layouts.adminlayout')

@section('content')
    <div class="flex-1 p-8">
        <h2 class="text-2xl font-bold text-gray-700 mb-4">Assign Permissions to Role</h2>

        <!-- Success & Error Messages -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-500 text-white p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('admin.assignPermission') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="role_id" class="block text-sm font-medium text-gray-700">Select Role</label>
                    <select name="role_id" id="role_id"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
                        <option value="">-- Select Role --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" 
                                {{ old('role_id', request('role_id')) == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Select Permissions</label>
                    <div class="bg-gray-100 p-3 rounded-lg shadow-sm" id="permissions-container">
                        @foreach ($permissions as $permission)
                            <div class="flex items-center mb-2">
                                <input type="checkbox" name="permission_id[]" value="{{ $permission->id }}" 
                                    class="mr-2 accent-blue-500 permission-checkbox"
                                    {{ in_array($permission->id, $assignedPermissions ?? []) ? 'checked' : '' }}>
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

    <!-- AJAX Script for Dynamic Permission Fetching -->
    <script>
        document.getElementById('role_id').addEventListener('change', function () {
            let roleId = this.value;
            if (roleId) {
                fetch(`/admin/get-permissions/${roleId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
                            checkbox.checked = data.includes(parseInt(checkbox.value));
                        });
                    });
            }
        });
    </script>
@endsection --}}
{{-- @extends('admin.layouts.adminlayout')

@section('content')
    <div class="flex-1 p-8">
        <h2 class="text-2xl font-bold text-gray-700 mb-4">Assign Permissions to Role</h2>

        <!-- Success & Error Messages -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-500 text-white p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('admin.assignPermission') }}" method="POST">
                @csrf

                <!-- Role Selection -->
                <div class="mb-4">
                    <label for="role_id" class="block text-sm font-medium text-gray-700">Select Role</label>
                    <select name="role_id" id="role_id"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
                        <option value="">-- Select Role --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" 
                                {{ old('role_id', request('role_id')) == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Permissions Selection -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Select Permissions</label>

                    <!-- Select All Checkbox -->
                    <div class="flex items-center mb-2">
                        <input type="checkbox" id="select-all" class="mr-2 accent-blue-500">
                        <label for="select-all" class="font-semibold text-gray-700">Select All</label>
                    </div>

                    <div class="bg-gray-100 p-3 rounded-lg shadow-sm" id="permissions-container">
                        @foreach ($permissions as $permission)
                            @if (!$permission->parent_id) <!-- If it's a Parent Permission -->
                                <div class="mb-2">
                                    <input type="checkbox" id="parent-{{ $permission->id }}" 
                                        class="mr-2 accent-blue-500 parent-checkbox"
                                        value="{{ $permission->id }}">
                                    <label class="text-sm font-semibold text-gray-800">{{ $permission->name }}</label>

                                    <!-- Child Permissions -->
                                    <div class="ml-6">
                                        @foreach ($permissions as $child)
                                            @if ($child->parent_id == $permission->id)
                                                <div class="flex items-center mb-1">
                                                    <input type="checkbox" name="permission_id[]" 
                                                        class="mr-2 accent-blue-500 child-checkbox"
                                                        value="{{ $child->id }}" 
                                                        data-parent="{{ $permission->id }}">
                                                    <label class="text-sm text-gray-600">{{ $child->name }}</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
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

    <!-- JavaScript for Select All & Parent-Child Selection -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const selectAll = document.getElementById('select-all');
            const parentCheckboxes = document.querySelectorAll('.parent-checkbox');
            const childCheckboxes = document.querySelectorAll('.child-checkbox');

            // Select All Functionality
            selectAll.addEventListener('change', function () {
                const checked = this.checked;
                parentCheckboxes.forEach(parent => parent.checked = checked);
                childCheckboxes.forEach(child => child.checked = checked);
            });

            // Parent Checkbox Controls Children
            parentCheckboxes.forEach(parent => {
                parent.addEventListener('change', function () {
                    const parentId = this.value;
                    const children = document.querySelectorAll(`.child-checkbox[data-parent="${parentId}"]`);
                    children.forEach(child => child.checked = this.checked);
                });
            });

            // If All Child Permissions Are Unchecked, Uncheck Parent
            childCheckboxes.forEach(child => {
                child.addEventListener('change', function () {
                    const parentId = this.dataset.parent;
                    const parentCheckbox = document.getElementById(`parent-${parentId}`);
                    const siblings = document.querySelectorAll(`.child-checkbox[data-parent="${parentId}"]`);
                    const allUnchecked = Array.from(siblings).every(sibling => !sibling.checked);
                    if (allUnchecked) parentCheckbox.checked = false;
                });
            });
        });
    </script>
@endsection --}}
@extends('admin.layouts.adminlayout')

@section('content')
    <div class="flex-1 p-8">
        <h2 class="text-2xl font-bold text-gray-700 mb-4">Assign Permissions to Role</h2>

        <!-- Success & Error Messages -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-500 text-white p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('admin.assignPermission') }}" method="POST">
                @csrf

                <!-- Role Selection -->
                <div class="mb-4">
                    <label for="role_id" class="block text-sm font-medium text-gray-700">Select Role</label>
                    <select name="role_id" id="role_id"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
                        <option value="">-- Select Role --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" 
                                {{ old('role_id', request('role_id')) == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Permissions Selection -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Select Permissions</label>

                    <!-- Select All Checkbox -->
                    <div class="flex items-center mb-2">
                        <input type="checkbox" id="select-all" class="mr-2 accent-blue-500">
                        <label for="select-all" class="font-semibold text-gray-700">Select All</label>
                    </div>

                    <div class="bg-gray-100 p-3 rounded-lg shadow-sm" id="permissions-container">
                        @foreach ($permissions as $permission)
                            @if (!$permission->parent_id) <!-- If it's a Parent Permission -->
                                <div class="mb-2">
                                    <input type="checkbox" id="parent-{{ $permission->id }}" 
                                        class="mr-2 accent-blue-500 parent-checkbox"
                                        value="{{ $permission->id }}">
                                    <label class="text-sm font-semibold text-gray-800">{{ $permission->name }}</label>

                                    <!-- Child Permissions -->
                                    <div class="ml-6">
                                        @foreach ($permissions as $child)
                                            @if ($child->parent_id == $permission->id)
                                                <div class="flex items-center mb-1">
                                                    <input type="checkbox" name="permission_id[]" 
                                                        class="mr-2 accent-blue-500 child-checkbox"
                                                        value="{{ $child->id }}" 
                                                        data-parent="{{ $permission->id }}">
                                                    <label class="text-sm text-gray-600">{{ $child->name }}</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
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

    <!-- JavaScript for Select All, Parent-Child, and Role-Based Auto Selection -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const selectAll = document.getElementById('select-all');
            const parentCheckboxes = document.querySelectorAll('.parent-checkbox');
            const childCheckboxes = document.querySelectorAll('.child-checkbox');

            // Select All Functionality
            selectAll.addEventListener('change', function () {
                const checked = this.checked;
                parentCheckboxes.forEach(parent => parent.checked = checked);
                childCheckboxes.forEach(child => child.checked = checked);
            });

            // Parent Checkbox Controls Children
            parentCheckboxes.forEach(parent => {
                parent.addEventListener('change', function () {
                    const parentId = this.value;
                    const children = document.querySelectorAll(`.child-checkbox[data-parent="${parentId}"]`);
                    children.forEach(child => child.checked = this.checked);
                });
            });

            // If All Child Permissions Are Unchecked, Uncheck Parent
            childCheckboxes.forEach(child => {
                child.addEventListener('change', function () {
                    const parentId = this.dataset.parent;
                    const parentCheckbox = document.getElementById(`parent-${parentId}`);
                    const siblings = document.querySelectorAll(`.child-checkbox[data-parent="${parentId}"]`);
                    const allUnchecked = Array.from(siblings).every(sibling => !sibling.checked);
                    if (allUnchecked) parentCheckbox.checked = false;
                });
            });

            // AJAX - Fetch Permissions for Selected Role
            document.getElementById('role_id').addEventListener('change', function () {
                let roleId = this.value;
                if (roleId) {
                    fetch(`/admin/get-permissions/${roleId}`)
                        .then(response => response.json())
                        .then(data => {
                            document.querySelectorAll('.parent-checkbox, .child-checkbox').forEach(checkbox => {
                                checkbox.checked = data.includes(parseInt(checkbox.value));
                            });
                        });
                }
            });
        });
    </script>
@endsection


