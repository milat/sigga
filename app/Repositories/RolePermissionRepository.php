<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;

abstract class RolePermissionRepository extends Repository
{
    /**
     *  Inserts permissions for new Role
     *
     *  @param Role $role
     *
     *  @return bool
     */
    public static function new(Role $role)
    {
        foreach (PermissionRepository::getAll() as $permission) {
            if (!self::save($role, $permission, false)) {
                return false;
            }
        }

        return true;
    }

    /**
     *  Persists role permissions
     *
     *  @param Role $role
     *  @param Permission $permission
     *  @param bool$isAllowed
     *
     *  @return bool
     */
    public static function save(Role $role, Permission $permission, $isAllowed)
    {
        $rolePermission = new RolePermission();
        $rolePermission->role_id = $role->id;
        $rolePermission->permission_id = $permission->id;
        $rolePermission->is_allowed = $isAllowed;

        return $rolePermission->save();
    }
}
