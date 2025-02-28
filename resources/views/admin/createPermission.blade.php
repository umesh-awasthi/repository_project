@extends('admin.layouts.adminlayout')
    <!-- Main Content -->

    @section('content')
<body>
    <h1>Create Permission</h1>
    <form action="{{ route('admin.createPermission') }}" method="POST">
        @csrf
        <label for="name">Permission Name:</label>
        <input type="text" name="name" id="name" required>
        <button type="submit">Create Permission</button>
    </form>
</body>
</html>
