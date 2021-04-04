<?php

namespace App\Services;

use App\Models\Office;
use App\Models\Permission;
use App\Models\RequestCategory;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 *  Generate Office and its dependencies
 *  based on config/generate.php
 */
abstract class GenerateService
{
    /**
     *  Create Office
     *
     *  @return Office
     */
    public static function createOffice()
    {
        return Office::create(config('generate.office'));
    }

    /**
     *  Create Roles
     *
     *  @param Office $office
     *
     *  @return array
     */
    public static function createRoles(Office $office)
    {
        $roles = [];

        foreach (config('generate.role') as $type => $role) {
            $role['office_id'] = $office->id;
            $roles[$type] = Role::create($role);
        }

        return $roles;
    }

    /**
     *  Create Permissions
     *
     *  @param array $roles
     *
     *  @return bool
     */
    public static function createRolePermissions(array $roles)
    {
        foreach ($roles as $type => $role) {
            foreach (Permission::all() as $permission) {
                if (!RolePermission::insert([
                    'role_id' => $role->id,
                    'permission_id' => $permission->id,
                    'is_allowed' => (bool)($type == 'administrator'),
                    'created_at' => now(),
                    'updated_at' => now()
                ])) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     *  Create Users
     *
     *  @param Office $office
     *  @param array $roles
     */
    public static function createUsers(Office $office, array $roles)
    {
        foreach (config('generate.user') as $type => $user) {
            $user['office_id'] = $office->id;
            $user['role_id'] = $roles[$type]->id;
            $user['password'] = Hash::make(config('system.generate_password'));
            if (!User::create($user)) {
                return false;
            }
        }

        return true;
    }

    /**
     *  Create Request Categories
     *
     *  @param Office $office
     *
     *  @return bool
     */
    public static function createRequestCategories(Office $office)
    {
        foreach (config('generate.category') as $category) {
            $category['office_id'] = $office->id;
            $category['colour'] = '#'.substr(md5(rand()), 0, 6);
            if (!RequestCategory::create($category)) {
                return false;
            }
        }

        return true;
    }
}
