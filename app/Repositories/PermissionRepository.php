<?php

namespace App\Repositories;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;

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
        $permission->delete();
    }
    public function isPermissionAssignedToRole($roleId, $permissionId)
{
    return DB::table('permission_role')
        ->where('role_id', $roleId)
        ->where('permission_id', $permissionId)
        ->exists();
}

public function assignPermissionToRole($roleId, $permissionId)
{
    return DB::table('permission_role')->insert([
        'role_id' => $roleId,
        'permission_id' => $permissionId,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}

}
