<?php

namespace App\Repositories;

use App\Models\Permission;

abstract class PermissionRepository extends Repository
{
    /**
     *  Returns all permissions
     *
     *  @return array
     */
    public static function getAll()
    {
        return Permission::all();
    }
}
