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
{{-- @endsection --}}


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
@endsection  --}}

{{-- ---------------------------------------------------- --}}
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

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Select Permissions</label>
                    <div class="mb-4 border-b pb-2">
                        <!-- Select All Checkbox -->
                        <div class="flex items-center">
                            <input type="checkbox" id="select-all" class="mr-2 accent-blue-500">
                            <label class="font-bold text-gray-700 uppercase">Select All</label>
                        </div>
                    </div>
                    
                    <div class="bg-gray-100 p-3 rounded-lg shadow-sm" id="permissions-container">
                        @php
                            $groupedPermissions = [];
                            foreach ($permissions as $permission) {
                                $prefix = explode('_', $permission->name)[0]; // Extract prefix
                                $groupedPermissions[$prefix][] = $permission;
                            }
                        @endphp

                        @foreach ($groupedPermissions as $prefix => $group)
                            <div class="mb-4 border-b pb-2">
                                <!-- Parent Checkbox -->
                                <div class="flex items-center">
                                    <input type="checkbox" class="mr-2 accent-blue-500 parent-checkbox" 
                                        data-prefix="{{ $prefix }}">
                                    <label class="font-bold text-gray-700 uppercase">{{ ucfirst($prefix) }} Manage</label>
                                </div>

                                <!-- Child Checkboxes -->
                                <div class="ml-6">
                                    @foreach ($group as $permission)
                                        <div class="flex items-center mb-1">
                                            <input type="checkbox" name="permission_id[]" value="{{ $permission->id }}" 
                                                class="mr-2 accent-blue-500 child-checkbox"
                                                data-prefix="{{ $prefix }}"
                                                {{ in_array($permission->id, $assignedPermissions ?? []) ? 'checked' : '' }}>
                                            <label class="text-sm text-gray-600">{{ $permission->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
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
    <script>
        var assignPermissionUrl = "{{ route('admin.assignPermission') }}";
        var csrfToken = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('js/permission.js') }}"></script>
    
    {{-- kk

    //     document.addEventListener('DOMContentLoaded', function () {
    //         const roleDropdown = document.getElementById('role_id'); 

    //         // Parent Checkbox Event
    //         document.querySelectorAll('.parent-checkbox').forEach(parent => {
    //             parent.addEventListener('change', function () {
    //                 let prefix = this.dataset.prefix;
    //                 let isChecked = this.checked;
                    
    //                 document.querySelectorAll(`.child-checkbox[data-prefix="${prefix}"]`).forEach(child => {
    //                     child.checked = isChecked;
    //                     updatePermissions(child.value, isChecked);
    //                 });

    //                 updatePermissions(); // Update backend
    //             });
    //         });

    //         // Child Checkbox Event
    //         document.querySelectorAll('.child-checkbox').forEach(child => {
    //             child.addEventListener('change', function () {
    //                 let prefix = this.dataset.prefix;
    //                 let parentCheckbox = document.querySelector(`.parent-checkbox[data-prefix="${prefix}"]`);
    //                 let allChecked = document.querySelectorAll(`.child-checkbox[data-prefix="${prefix}"]:checked`).length === 
    //                                  document.querySelectorAll(`.child-checkbox[data-prefix="${prefix}"]`).length;
                    
    //                 parentCheckbox.checked = allChecked; // Auto-check parent if all children are checked
                    
    //                 updatePermissions(this.value, this.checked);
    //             });
    //         });

    //         // Update Database with AJAX
    //         function updatePermissions(permissionId = null, status = null) {
    //             let roleId = roleDropdown.value;
    //             if (!roleId) return;

    //             let permissions = [];
    //             document.querySelectorAll('.child-checkbox:checked').forEach(checkbox => {
    //                 permissions.push(checkbox.value);
    //             });

    //             fetch("{{ route('admin.assignPermission') }}", {
    //                 method: "POST",
    //                 headers: {
    //                     "Content-Type": "application/json",
    //                     "X-CSRF-TOKEN": "{{ csrf_token() }}"
    //                 },
    //                 body: JSON.stringify({ role_id: roleId, permission_id: permissions })
    //             }).then(response => response.json())
    //             .then(data => {
    //                 console.log("Permissions Updated:", data);
    //             }).catch(error => {
    //                 console.error("Error updating permissions:", error);
    //             });
    //         }

    //         // Fetch Permissions for Selected Role
    //         roleDropdown.addEventListener('change', function () {
    //             let roleId = this.value;
    //             if (!roleId) return;

    //             fetch(`/admin/get-permissions/${roleId}`)
    //                 .then(response => response.json())
    //                 .then(data => {
    //                     document.querySelectorAll('.child-checkbox').forEach(checkbox => {
    //                         checkbox.checked = data.includes(parseInt(checkbox.value));
    //                     });

    //                     // Sync Parent Checkboxes
    //                     document.querySelectorAll('.parent-checkbox').forEach(parent => {
    //                         let prefix = parent.dataset.prefix;
    //                         let allChecked = document.querySelectorAll(`.child-checkbox[data-prefix="${prefix}"]:checked`).length === 
    //                                          document.querySelectorAll(`.child-checkbox[data-prefix="${prefix}"]`).length;
    //                         parent.checked = allChecked;
    //                     });
    //                 });
    //         });
    //     });
     {{-- </script> --}}
@endsection
{{-- ---------------------------------------------------- --}}

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

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Select Permissions</label>
                    <div class="bg-gray-100 p-3 rounded-lg shadow-sm" id="permissions-container">
                        @php
                            $groupedPermissions = [];
                            foreach ($permissions as $permission) {
                                $prefix = explode('_', $permission->name)[0]; // Extract prefix
                                $groupedPermissions[$prefix][] = $permission;
                            }
                        @endphp

                        @foreach ($groupedPermissions as $prefix => $group)
                            <div class="mb-4 border-b pb-2">
                                <!-- Parent Checkbox -->
                                <div class="flex items-center">
                                    <input type="checkbox" class="mr-2 accent-blue-500 parent-checkbox" 
                                        data-prefix="{{ $prefix }}">
                                    <label class="font-bold text-gray-700 uppercase">{{ ucfirst($prefix) }} Manage</label>
                                </div>

                                <!-- Child Checkboxes -->
                                <div class="ml-6">
                                    @foreach ($group as $permission)
                                        <div class="flex items-center mb-1">
                                            <input type="checkbox" name="permission_id[]" value="{{ $permission->id }}" 
                                                class="mr-2 accent-blue-500 child-checkbox"
                                                data-prefix="{{ $prefix }}"
                                                {{ in_array($permission->id, $assignedPermissions ?? []) ? 'checked' : '' }}>
                                            <label class="text-sm text-gray-600">{{ $permission->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
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

    <!-- Link JavaScript File -->
   <script src="{{ asset('js/permission.js') }}"></script>

@endsection --}}
