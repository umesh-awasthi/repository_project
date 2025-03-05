<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex bg-gray-100 min-h-screen">

    <!-- Sidebar -->
    <div class="w-64 bg-gray-900 text-white min-h-screen p-4">
        <h2 class="text-xl font-bold mb-4">Panel</h2>
        
        @php
            $permissions = session('user_permissions', []);
        @endphp

        <nav class="space-y-2">
            <!-- Dashboard -->
            @if(in_array('dashboard', $permissions))
                <a href="{{ route('dashboard') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Dashboard</a>
            @endif
            
            <!-- Users -->
            @if(in_array('user_view', $permissions))
                <a href="{{ route('agent.userlist') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Users</a>
            @endif
            
            <!-- Roles -->
            @if(in_array('role_view', $permissions))
                <a href="{{ route('roles') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Roles</a>
            @endif
            
            <!-- Settings -->
            @if(in_array('manage_settings', $permissions))
                <a href="{{ route('admin.setting') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Settings</a>
            @endif

            <!-- Todos -->
            @if(in_array('todo_view', $permissions))
                <a href="{{ route('todos.list') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Todos</a>
            @endif
        </nav>
    </div>

    @yield('content')
    
</body>
</html>
