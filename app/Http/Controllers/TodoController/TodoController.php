<?php

namespace App\Http\Controllers\TodoController;

use App\Http\Controllers\Controller;
use App\Repositories\TodoRepositoryInterface;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    protected $todoRepository;

    public function __construct(TodoRepositoryInterface $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function index()
    {
        $todos = $this->todoRepository->all();
        return view('todos.index', compact('todos'));
    }

    public function create()
    {
        return view('todos.create');
    }

    public function edit($id)
    {
        $todo = $this->todoRepository->find($id);
        return view('todos.edit', compact('todo'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'completed' => 'boolean',
        ]);

        $this->todoRepository->create($data);
        return redirect()->route('todos.index');
    }

    public function show($id)
    {
        $todo = $this->todoRepository->find($id);
        return view('todos.show', compact('todo'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'string|max:255',
            'completed' => 'boolean',
        ]);

        $todo = $this->todoRepository->update($id, $data);
        return redirect()->route('todos.index');
    }

    public function destroy($id)
    {
        $this->todoRepository->delete($id);
        return redirect()->route('todos.index');
    }

    // API Methods
    public function apiIndex()
    {
        $todos = $this->todoRepository->all();
        
        return response()->json(
            ["This Is Your Data "=>$todos],200
        );
    }

    public function apiShow($id)
    {
        $todo = $this->todoRepository->find($id);
        return response()->json($todo);
    }

    public function apiStore(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'completed' => 'boolean',
        ]);

        $todo = $this->todoRepository->create($data);
        return response()->json($todo, 201);
    }

    public function apiUpdate(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'string|max:255',
            'completed' => 'boolean',
        ]);

        $todo = $this->todoRepository->update($id, $data);
        return response()->json($todo);
    }

    public function apiDestroy($id)
    {
        $this->todoRepository->delete($id);
        return response()->json(null, 204);
    }
}
