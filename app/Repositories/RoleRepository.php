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

    public function Permissions()
    {
        return Permission::all();
    }

    public function rolls()
    {
        return Role::all();
    }
}
