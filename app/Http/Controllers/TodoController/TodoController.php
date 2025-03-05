<?php

namespace App\Http\Controllers\TodoController;

use App\Http\Controllers\Controller;
use App\Repositories\TodoRepositoryInterface;
use App\Repositories\PermissionRepositoryInterface;
use App\Repositories\RoleRepositoryInterface;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    protected $todoRepository;
    protected $permissionRepository;
    protected $roleRepository;

    public function __construct(TodoRepositoryInterface $todoRepository , 
    PermissionRepositoryInterface $permissionRepository ,
     RoleRepositoryInterface $roleRepository)
    {
        $this->todoRepository = $todoRepository;
        $this->permissionRepository = $permissionRepository;
        $this->roleRepository = $roleRepository;    
    }

    public function index()
    {
        $todos = $this->todoRepository->all();
    
        // Ensure user is authenticated
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }
    
        // Fetch roles using RoleRepository
        $roles = $this->roleRepository->getUserRoles($user);
    
        // Fetch permissions using PermissionRepository
        $permissions = $this->permissionRepository->getPermissionsByRoles($roles)
            ->pluck('name') // Extract only names
            ->unique() // Remove duplicates
            ->toArray(); // Convert to array for easy use in Blade
    
        return view('todos.index', compact('todos', 'permissions'));
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
        return redirect()->route('todos.list');
    }

    public function show($id)
    {
        $todo = $this->todoRepository->find($id);
        return view('todos.show', compact('todo'));
    }

    public function update(Request $request, $id)
    {
        // Check if the todo item exists
        $todo = $this->todoRepository->find($id);
        if (!$todo) {
            return redirect()->route('todos.index')->with('error', 'Todo not found.');
        }

        // Validate the request data
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'completed' => 'boolean',
        ]);

        // Update the todo item
        $todo = $this->todoRepository->update($id, $data);
        return redirect()->route('todos.list')->with('success', 'Todo updated successfully.');
    }

    public function destroy($id)
    {
        $this->todoRepository->delete($id);
        return redirect()->route('todos.list');
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
