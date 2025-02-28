<?php

namespace App\Repositories;

use App\Models\Todo;

class TodoRepository implements TodoRepositoryInterface
{
    public function all()
    {
        return Todo::all();
    }

    public function find($id)
    {
        return Todo::find($id);
    }

    public function create(array $data)
    {
        return Todo::create($data);
    }

    public function update($id, array $data)
    {
        $todo = Todo::find($id);
        $todo->update($data);
        return $todo;
    }

    public function delete($id)
    {
        return Todo::destroy($id);
    }
}
