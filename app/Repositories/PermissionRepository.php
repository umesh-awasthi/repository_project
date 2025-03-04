<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\Role;

class PermissionRepository implements PermissionRepositoryInterface
{
    public function all()
    {
        return Permission::all();
    }

    public function create(array $data)
    {
        // Check if the permission already exists
        if (Permission::where('name', $data['name'])->exists()) {
            return 'Permission already exists.';
        }

        return Permission::create($data);
    }

    public function find($id)
    {
        return Permission::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $permission = $this->find($id);
        $permission->update($data);
        return $permission;
    }

    public function delete($id)
    {
        $permission = $this->find($id);
        return $permission->delete(); // Return true/false
    }

    /**
     * Check if a permission is already assigned to a role.
     */
    public function isPermissionAssignedToRole($roleId, $permissionId)
    {
        $role = Role::findOrFail($roleId);
        return $role->permissions()->where('permissions.id', $permissionId)->exists();
    }

    /**
     * Assign a permission to a role.
     */
    public function assignPermissionToRole($roleId, $permissionId)
    {
        $role = Role::findOrFail($roleId);
        $role->permissions()->syncWithoutDetaching([$permissionId]); // Prevent duplicates
    }
}
