<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\RoleRepositoryInterface;
use App\Repositories\PermissionRepositoryInterface;
use App\Repositories\RegistrationRepositoryInterface;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected $roleRepository;
    protected $permissionRepository;
    protected $registrationRepository;

    public function __construct(
        RoleRepositoryInterface $roleRepository,
        PermissionRepositoryInterface $permissionRepository,
        RegistrationRepositoryInterface $registrationRepository
    ) {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
        $this->registrationRepository = $registrationRepository;
    }

    public function showRegistrationForm()
    {
        $roles = $this->roleRepository->all();
        $permissions = $this->permissionRepository->all();
        return view('auth.register', compact('roles', 'permissions'));
    }
  
   
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,id'
        ]);

        // Create user with role
        $user = $this->registrationRepository->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role
        ]);

        // Assign role through pivot table
        $user->roles()->attach($request->role);

        // Assign permissions if any
        if ($request->has('permissions')) {
            $user->permissions()->attach($request->permissions);
        }

        return redirect()->route('admin.index')->with('success', 'User registered successfully.');
    }
}
