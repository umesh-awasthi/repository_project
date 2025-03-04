<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex bg-gray-100 min-h-screen">

    <!-- Sidebar -->
    <div class="w-64 bg-gray-900 text-white min-h-screen p-4">
        <h2 class="text-xl font-bold mb-4">Panel</h2>
        <nav class="space-y-2">
            <a href={{route('dashboard')}} class="block py-2 px-4 hover:bg-gray-700 rounded">Dashboard</a>
            {{-- <a href={{route('admin.users')}} class="block py-2 px-4 hover:bg-gray-700 rounded">Users</a>
            <a href={{route('roles')}} class="block py-2 px-4 hover:bg-gray-700 rounded">Roles</a>

            <a href={{route('admin.setting')}} class="block py-2 px-4 hover:bg-gray-700 rounded">Settings</a> --}}
            <a href={{route('todos.list')}} class="block py-2 px-4 hover:bg-gray-700 rounded">Todos</a>
        </nav>
    </div>
    @yield('content')
</body>
</html>