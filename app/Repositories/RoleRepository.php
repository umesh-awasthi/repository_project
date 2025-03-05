<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\Permission;

class RoleRepository implements RoleRepositoryInterface
{
    public function all()
    {
        return Role::all();
    }

    public function create(array $data)
    {
        // Check if the role already exists
        if (Role::where('name', $data['name'])->exists()) {
            return 'Role already exists.';
        }
        return Role::create($data);
    }

    public function edit($id)
    {
        return Role::findOrFail($id);
    }

    public function find($id)
    {
        return Role::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $role = $this->find($id);
        $role->update($data);
        return $role;
    }

    public function delete($id)
    {
        return Role::destroy($id);
    }

    public function permissions()
    {
        return Permission::all();
    }

    public function roles()
    {
        return Role::all();
    }

    /**
     * Assign permissions to a role.
     */
    public function assignPermissions($roleId, array $permissionIds)
    {
        $role = $this->find($roleId);
        $role->permissions()->syncWithoutDetaching($permissionIds); // Avoid duplicates
    }

    /**
     * Get permissions assigned to a specific role.
     */
    public function getRolePermissions($roleId)
    {
        return $this->find($roleId)->permissions;
    }

    /**
     * Get roles assigned to a specific user.
     */
    public function getUserRoles($user)
    {
        return $user->roles; // Assuming a many-to-many relationship
    }
}
