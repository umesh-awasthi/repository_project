<?php


namespace App\Http\Controllers\Auth;

use App\Repositories\UserRepository; // Import UserRepository
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\RoleRepository;
use App\Repositories\PermissionRepository;

class RegisterController extends Controller
{
    protected $roleRepository;
    protected $permissionRepository;

    public function __construct(RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    
    public function login(Request $request) 

{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        return redirect()->route('dashboard')->with('success', 'Login successful!');
    }

    return back()->with('error', 'Invalid credentials. Please try again.');
}

public function logout(Request $request)
{
    Auth::logout();
    return redirect()->route('login')->with('success', 'Logged out successfully!');
}



}
