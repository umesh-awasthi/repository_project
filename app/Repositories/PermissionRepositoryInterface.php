<?php

namespace App\Repositories;

interface PermissionRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function find($id);
    public function update($id, array $data);
    public function delete($id);
    public function isPermissionAssignedToRole($roleId,$permissionId);
    public function assignPermissionToRole($roleId, $permissionId);
}
