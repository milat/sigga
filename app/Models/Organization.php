<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Organization extends Model
{
    /**
     *  @var string
     */
    protected $table = 'organizations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'office_id',
        'name',
        'branch',
        'identity_document',
        'email',
        'contact',
        'note',
        'is_active',
        'created_by_user_id',
        'updated_by_user_id'
    ];

    /**
     *  @return HasOne
     */
    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'created_by_user_id')
                    ->where('office_id', Auth::user()->office_id);
    }

    /**
     *  @return HasOne
     */
    public function updater()
    {
        return $this->hasOne(User::class, 'id', 'updated_by_user_id')
                    ->where('office_id', Auth::user()->office_id);
    }

    /**
     *  @return HasOne
     */
    public function address()
    {
        return $this->hasOne(Address::class, 'owner_id', 'id')
                    ->where('owner_type', self::class);
    }

    /**
     *  @return HasOne
     */
    public function phone()
    {
        return $this->hasOne(Phone::class, 'owner_id', 'id')
                    ->where('owner_type', self::class)
                    ->where('is_main', true);
    }

    /**
     *  @return HasOne
     */
    public function phone2()
    {
        return $this->hasOne(Phone::class, 'owner_id', 'id')
                    ->where('owner_type', self::class)
                    ->where('is_main', false);
    }

    /**
     *  searches for organization by query
     *
     *  @param string $query
     *
     *  @return array
     */
    public static function search(string $query)
    {
        return self::where('office_id', '=', Auth::user()->office_id)
                    ->where(function ($where) use ($query) {
                        $where->whereRaw('LOWER(name) LIKE "%'.strtolower($query).'%"')
                        ->orWhereRaw('LOWER(identity_document) LIKE "%'.strtolower($query).'%"')
                        ->orWhereRaw('LOWER(branch) LIKE "%'.strtolower($query).'%"')
                        ->orWhereRaw('LOWER(contact) LIKE "%'.strtolower($query).'%"')
                        ->orWhereRaw('LOWER(email) LIKE "%'.strtolower($query).'%"');
                    })
                    ->orderBy('is_active', 'desc')
                    ->orderBy('name')
                    ->paginate(config('system.paginate'));
    }

    /**
     *  Returns office's active organizations
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

    /**
     *  Returns distinct branches
     *
     *  @return array
     */
    public static function getAllBranches()
    {
        return self::select('branch')
                    ->where('office_id', Auth::user()->office_id)
                    ->distinct()->get();
    }
}
