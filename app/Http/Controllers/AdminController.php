<?php

namespace App\Http\Controllers;

use App\Repositories\RoleRepositoryInterface;
use App\Repositories\PermissionRepositoryInterface;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $roleRepository;
    protected $permissionRepository;

    public function __construct(RoleRepositoryInterface $roleRepository, PermissionRepositoryInterface $permissionRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public function createRole()
    {
        return view('admin.createRole');
    }
    public function createPermission()
    {
        return view('admin.createPermission');
    }

    public function index()
    {
        $roles = $this->roleRepository->all();
        $permissions = $this->permissionRepository->all();
        return view('admin.index', compact('roles', 'permissions'));
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

    public function assignPermission(Request $request)
    {
        $data = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'required|exists:permissions,id',
        ]);
        $role = $this->roleRepository->find($data['role_id']);
        $role->permissions()->attach($data['permission_id']);
        return redirect()->route('admin.index');
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
}
