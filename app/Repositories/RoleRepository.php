<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request as HttpRequest;

class RoleRepository extends Repository
{
    /**
     *  Finds role by id
     *
     *  @param int $id
     *
     *  @return Role|bool
     */
    public static function find(int $id)
    {
        return self::findIn(Role::class, $id);
    }

    /**
     *  Searches for role by query
     *
     *  @param string $query
     *
     *  @return array
     */
    public static function search(string $query)
    {
        return Role::search($query);
    }

    /**
     *  Persists role
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return Role|bool
     */
    public static function insert(HttpRequest $httpRequest)
    {
        $role = new Role;
        $role->office_id = Auth::user()->office_id;
        self::set($role, $httpRequest);

        DB::beginTransaction();

        if ($role->save() && RolePermissionRepository::new($role)) {
            DB::commit();
            return $role;
        }

        DB::rollBack();
        return false;
    }

    /**
     *  Updates role
     *
     *  @param Role $role
     *  @param HttpRequest $httpRequest
     *
     *  @return bool
     */
    public static function update(Role $role, HttpRequest $httpRequest)
    {
        self::set($role, $httpRequest);
        return $role->save();
    }

    /**
     *  Updates role permission
     *
     *  @param Role $role
     *  @param Request $request
     *
     *  @return bool
     */
    public static function access(Role $role, HttpRequest $httpRequest)
    {
        if ($role->id != $httpRequest->role_id) {
            return false;
        }

        $isAllowed = (bool)($httpRequest->is_allowed && $httpRequest->is_allowed == 'true');

        return RolePermission::change(
            $role,
            $httpRequest->permission_id,
            $isAllowed
        );
    }

    /**
     *  Sets role model with HttpRequest
     *
     *  @param Role $role
     *  @param HttpRequest $httpRequest
     *
     *  @return void
     */
    private static function set(Role &$role, HttpRequest $httpRequest)
    {
        $role->name = $httpRequest->role_name;
        $role->is_active = $httpRequest->role_is_active;
    }
}
