<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     *  @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'office_id',
        'role_id',
        'name',
        'email',
        'email_verified_at',
        'password',
        'identity_document',
        'note',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     *  Returns password
     *
     *  @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     *  @return HasOne
     */
    public function type()
    {
        return $this->hasOne(OwnerType::class, 'id', 'owner_type_id');
    }

    /**
     *  @return HasOne
     */
    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id')
                    ->where('office_id', Auth::user()->office_id);
    }

    /**
     *  Check if user's role has the permission
     *
     *  @param string $permission
     *
     *  @return bool
     */
    public function hasPermission(string $permission) {
        return $this->role->permits->contains('code', $permission);
    }

    /**
     *  Search office's users by query
     *
     *  @param string $query
     *
     *  @return array
     */
    public static function search(string $query)
    {
        return self::with('role')
                    ->where('office_id', '=', Auth::user()->office_id)
                    ->where(function ($where) use ($query) {
                        $where->whereRaw('LOWER(name) LIKE "%'.strtolower($query).'%"')
                            ->orWhereRaw('LOWER(email) LIKE "%'.strtolower($query).'%"');
                    })
                    ->orderBy('is_active', 'desc')
                    ->orderBy('name')
                    ->paginate(config('system.paginate'));
    }

    /**
     *  Return office's active users
     *
     *  @return array
     */
    public static function getActives()
    {
        return self::where('office_id', Auth::user()->office_id)
                    ->where('is_active', true)
                    ->orderBy('name')
                    ->get();
    }
}
