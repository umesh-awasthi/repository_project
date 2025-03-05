<?php

namespace App\Http\Controllers;

use App\Repositories\RoleRepositoryInterface;
use App\Repositories\PermissionRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $roleRepository;
    protected $permissionRepository;
    protected $userRepository;

    public function __construct(RoleRepositoryInterface $roleRepository, PermissionRepositoryInterface $permissionRepository, UserRepositoryInterface $userRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
        $this->userRepository = $userRepository;
    }

    public function createRole()
    {
        return view('admin.createRole');
    }
    public function createPermission()
    {
        return view('admin.createPermission');
    }

    public function index(Request $request)
    {
        $roles = $this->roleRepository->all();
        $permissions = $this->permissionRepository->all();
        
        $assignedPermissions = [];
        if ($request->has('role_id')) {
            $role = $this->roleRepository->find($request->role_id);
            $assignedPermissions = $role->permissions->pluck('id')->toArray();
        }

        return view('admin.assignPermissions', compact('roles', 'permissions', 'assignedPermissions'));
    }

    public function show()
    {
        $roles = $this->roleRepository->all();

        return view('admin.role', compact('roles'));
    }

    public function storeRole(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);



        $response = $this->roleRepository->create($data);
        if ($response === 'Role already exists.') {
            return redirect()->back()->withErrors(['name' => $response])->withInput();
        }
        return redirect()->route('roles')->with('success', 'Role created successfully!');
    }

    public function storePermission(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $this->permissionRepository->create($data);
        return redirect()->route('admin.index');
    }

    public function assignRole(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);
        $user = User::findOrFail($data['user_id']);
        $user->roles()->attach($data['role_id']);
        return redirect()->route('admin.index');
    }
    // public function assignPermission(Request $request)
    // {
    //     $data = $request->validate([
    //         'role_id' => 'required|exists:roles,id',
    //         'permission_id' => 'required|exists:permissions,id',
    //     ]);
    //     $role = $this->roleRepository->find($data['role_id']);

    //     foreach ($data['permission_id'] as $permissionId) {
    //         // Check if the combination already exists
    //         if (!$role->permissions()->where('permission_id', $permissionId)->exists()) {
    //             $role->permissions()->attach($permissionId);
    //         }
    //     }
    //     return redirect()->route('admin.index',compact('role'))->with('success',"Permission assigened successfully!");
    // }
//     public function assignPermission(Request $request)
// {
//     $data = $request->validate([
//         'role_id' => 'required|exists:roles,id',
//         'permission_id' => 'required|array',
//         'permission_id.*' => 'exists:permissions,id',
//     ]);

//     $role = $this->roleRepository->find($data['role_id']);

//     if (!$role) {
//         return redirect()->back()->with('error', 'Role not found.');
//     }

//     // Assign permissions without duplicating existing ones
//     $role->permissions()->syncWithoutDetaching($data['permission_id']);

//     return redirect()->route('admin.index')->with('success', 'Permissions assigned successfully!');
// }
// all work currect
// public function assignPermission(Request $request)
// {
//     $data = $request->validate([
//         'role_id' => 'required|exists:roles,id',
//         'permission_id' => 'array', // Make it optional to allow removing all permissions
//         'permission_id.*' => 'exists:permissions,id',
//     ]);

//     $role = $this->roleRepository->find($data['role_id']);

//     if (!$role) {
//         return redirect()->back()->with('error', 'Role not found.');
//     }

//     // Use sync() to update permissions (add new & remove unchecked)
//     $role->permissions()->sync($data['permission_id'] ?? []);

//     // Fetch updated permissions for the role
//     $permissions = $role->permissions()->pluck('name')->unique()->toArray();

//     // Store in session
//     session(['user_permissions' => $permissions]);

//     return redirect()->route('admin.index')->with('success', 'Permissions updated successfully!');
// }
public function assignPermission(Request $request)
{
    $request->validate([
        'role_id' => 'required|exists:roles,id',
        'permission_id' => 'nullable|array', // Allows empty array (removing all permissions)
        'permission_id.*' => 'exists:permissions,id',
    ]);

    $role = $this->roleRepository->find($request->role_id);

    if (!$role) {
        return $request->ajax()
            ? response()->json(['error' => 'Role not found'], 404)
            : redirect()->back()->with('error', 'Role not found.');
    }

    // Sync permissions (removes unchecked, adds new ones)
    $role->permissions()->sync($request->permission_id ?? []);

    // Get updated permissions
    $permissions = $role->permissions()->pluck('name')->unique()->toArray();

    // Update session only if it's a normal request
    if (!$request->ajax()) {
        session(['user_permissions' => $permissions]);
        return redirect()->route('admin.index')->with('success', 'Permissions updated successfully!');
    }

    // Return JSON response for AJAX
    return response()->json(['success' => 'Permissions updated successfully', 'permissions' => $permissions]);
}





    public function edit($id)
    {
        $role = $this->roleRepository->edit($id);
        return view('admin.editeRole', compact('role'));
    }

    public function deleteRole($id)
    {
        $this->roleRepository->delete($id);
        return redirect()->route('roles')->with('success', 'Role deleted successfully!');
    }



    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $this->roleRepository->update($id, $data);
        return redirect()->route('roles')->with('success', 'Role updated successfully!');
    }
    // User Repository 
    public function showUsers()
    {
        $users = $this->userRepository->all();
        
        return view('admin.users.userlist', compact('users'));
    }
    public function createuser()
    {
        $roles = $this->roleRepository->all();
        return view('auth.register', compact('roles'));
    }
    public function storeuser(Request $request)
    {
        \Log::info('Incoming request data:', $request->all()); // Debugging statement

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id', // Corrected from 'role' to 'role_id'



        ]);

        $response = $this->userRepository->create($data);
        if ($response === 'Email already exists.') {
            return redirect()->back()->withErrors(['email' => $response])->withInput();
        }
        return redirect()->route('admin.users')->with('success', 'user created successfully!');
    }
    public function edituser($id)
    {
        $user = $this->userRepository->edit($id);
        $roles = $this->roleRepository->all();
        return view('admin.users.edituser', compact('user', 'roles'));
    }

    public function deleteuser($id)
    {
        $this->userRepository->delete($id);
        return redirect()->route('admin.users')->with('success', 'User  deleted successfully!');
    }
    public function updateuser(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role_id' => 'required|exists:roles,id', // Ensure role_id exists in roles table
        ]);

        $this->userRepository->update($id, $data);

        return redirect()->route('admin.users')->with('success', 'User updated successfully!');
    }



    public function setting()
    {
        $roles = $this->roleRepository->all();
        $permissions = $this->permissionRepository->all();
        return view('admin.settings', compact('roles', 'permissions'));
    }

    public function dashboard()
    {
        $user = $this->userRepository->find(auth()->id());
    
        // Extract role names correctly
        $roles = $user->roles->pluck('name')->toArray();
        
        // Get permissions for the user's roles
        $permissions = [];
        foreach ($user->roles as $role) {
            $permissions = array_merge($permissions, $role->permissions->pluck('name')->toArray());
        }
        $permissions = array_unique($permissions);
    
        if (in_array('admin', $roles)) {
            return view('admin.dashboard', ['permissions' => $permissions]);
        } elseif (in_array('agent', $roles)) {
        
            return view('auth.dashboard', ['permissions' => $permissions]);
        } else {
            return view('admin.users.dashboard', ['permissions' => $permissions]);
        }
    }
    


    // public function dashboard()
// {
//     $user = $this->userRepository->find(auth()->id()); // Get the currently authenticated user using the repository

    //     if ($user->role === 'admin') {
//         return view('admin.dashboard'); // Redirect to admin dashboard
//     } elseif ($user->role === 'agent') {
//         return view('auth.dashboard'); // Redirect to agent dashboard
//     } else {
//         return view('admin.users.dashboard'); // Redirect to normal user dashboard
//     }
// }


    public function viewPermissions()
    {
        $permissions = $this->permissionRepository->all();
        return view('admin.permissions', compact('permissions'));
    }
    // auth layout permissions
    public function viewAuthPermissions(){
        $permissions = $this->permissionRepository->all();
        return view('layout.app', compact('permissions'));
    }

    public function getPermissions($roleId)
    {
        $role = $this->roleRepository->find($roleId);
        if (!$role) {
            return response()->json([]);
        }
        return response()->json($role->permissions->pluck('id')->toArray());
    }

    public function deletePermission($id)
    {
        $this->permissionRepository->delete($id);
        return redirect()->route('viewPermissions')->with('success', 'Permission  deleted successfully!');
    }

}
