<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Todo</title>
</head>
<body>
    <h1>Create New Todo</h1>
    <form action="{{ route('todos.store') }}" method="POST">
        @csrf
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <button type="submit">Create Todo</button>
    </form>
    <a href="{{ route('todos.index') }}">Back to Todo List</a>
</body>
</html>
