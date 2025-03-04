<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function all()
    {
        return User::all();
    }

    public function edit($id)
    {
        return User::findOrFail($id);
    }
    public function find($id)
    {
        return User::findOrFail($id);
    }
    public function create(array $data)
    {
        // Check if the email already exists
        if (User::where('email', $data['email'])->exists()) {
            return 'Email already exists.';
        }
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']), // Ensure password is hashed
            'role' => $data['role_id'], // Include role_id in user creation
        ]);
    }

    public function update($id, array $data)
{
    $user = $this->edit($id); // Fetch the user

    // Update user details
    $user->update([
        'name' => $data['name'],
        'email' => $data['email'],
    ]);

    // Check if role_id exists and update it
    if (isset($data['role_id'])) {
        $user->role= $data['role_id']; // Assuming role_id is a column in the users table
        $user->save();
    }

    return $user;
}


    public function delete($id)
    {
        $user = $this->find($id);
        return $user->delete();
    }
}
