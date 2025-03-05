<?php

namespace App\Http\Controllers;
use App\Repositories\RoleRepositoryInterface;
use App\Repositories\PermissionRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;


class agentcontroller extends Controller
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
     // User Repository 
     public function showUsers()
     {
         $users = $this->userRepository->all();
       
    
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
         return view('auth.users.userlist', compact('users','permissions'));
     }
     public function createuser()
     {
         $roles = $this->roleRepository->all();
         return view('auth.users.registeruser', compact('roles'));
     }
     public function storeuser(Request $request)
     {
        //  \Log::info('Incoming request data:', $request->all()); // Debugging statement
 
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
         return redirect()->route('agent.userlist')->with('success', 'user created successfully!');
     }
     public function edituser($id)
     {
         $user = $this->userRepository->edit($id);
         $roles = $this->roleRepository->all();
         return view('auth.users.edituser', compact('user', 'roles'));
     }
 
     public function deleteuser($id)
     {
         $this->userRepository->delete($id);
         return redirect()->route('agent.userlist')->with('success', 'User  deleted successfully!');
     }
     public function updateuser(Request $request, $id)
     {
         $data = $request->validate([
             'name' => 'required|string|max:255',
             'email' => 'required|email|unique:users,email,' . $id,
             'role_id' => 'required|exists:roles,id', // Ensure role_id exists in roles table
         ]);
 
         $this->userRepository->update($id, $data);
 
         return redirect()->route('agent.userlist')->with('success', 'User updated successfully!');
     }
 
 
 
    //  public function setting()
    //  {
    //      $roles = $this->roleRepository->all();
    //      $permissions = $this->permissionRepository->all();
    //      return view('admin.settings', compact('roles', 'permissions'));
    //  }
}
