<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RolePermission extends Model
{
    /**
     *  @var string
     */
    protected $table = 'role_permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'permission_id',
        'role_id',
        'is_allowed'
    ];

    /**
     *  @return HasOne
     */
    public function permission()
    {
        return $this->hasOne(Permission::class, 'id', 'permission_id');
    }

    /**
     *  @return HasOne
     */
    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    /**
     *  Updates 'is_allowed' field
     *
     *  @param Role $role
     *  @param int $permissionId
     *  @param bool $isAllowed
     *
     *  @return bool
     */
    public static function change(Role $role, int $permissionId, bool $isAllowed)
    {
        return self::where('role_id', $role->id)
                    ->where('permission_id', $permissionId)
                    ->update([
                        'is_allowed' => $isAllowed
                    ]);
    }
}
