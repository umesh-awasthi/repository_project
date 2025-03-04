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

        // Create user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']), // Ensure password is hashed
            'role' => $data['role_id'],
        ]);

        // Attach role(s) if provided
        if (isset($data['role_id'])) {
            $user->roles()->attach($data['role_id']); // Assign role using many-to-many relationship
        }

        return $user;
    }

    public function update($id, array $data)
    {
        $user = $this->edit($id); // Fetch the user

        // Update user details
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        // Update role(s) if provided
        if (isset($data['role_id'])) {
            $user->roles()->sync($data['role_id']); // Sync roles to avoid duplicates
        }

        return $user;
    }

    public function delete($id)
    {
        $user = $this->find($id);
        return $user->delete();
    }
}
