<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    /**
     *  @var string
     */
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'office_id',
        'name',
        'is_active'
    ];

    /**
     *  @return HasMany
     */
    public function permits()
    {
        return $this->hasManyThrough(Permission::class, RolePermission::class, 'role_id', 'id', 'id', 'permission_id')
                    ->where('role_permissions.is_allowed', true);
    }

    /**
     *  @return HasMany
     */
    public function permissions()
    {
        return $this->hasMany(RolePermission::class, 'role_id', 'id');
    }

    /**
     *  Returns office's active roles
     *
     *  @return array
     */
    public static function actives()
    {
        return self::where('office_id', Auth::user()->office_id)
                    ->where('is_active', true)
                    ->get();
    }

    /**
     *  Search office's roles by query
     *
     *  @param string $query
     *
     *  @return self
     */
    public static function search(string $query)
    {
        return self::where('office_id', '=', Auth::user()->office_id)
                    ->where(function ($where) use ($query) {
                        $where->whereRaw('LOWER(name) LIKE "%'.strtolower($query).'%"');
                    })
                    ->orderBy('is_active', 'desc')
                    ->orderBy('name')
                    ->paginate(config('system.paginate'));
    }
}
