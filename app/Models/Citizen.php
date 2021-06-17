<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Citizen extends Model
{
    /**
     *  @var string
     */
    protected $table = 'citizens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'office_id',
        'name',
        'identity_document',
        'email',
        'birth',
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
     *  @return HasMany
     */
    public function dependents()
    {
        return $this->hasMany(Dependent::class, 'citizen_id', 'id');
    }

    /**
     *  Searches for citizen by query
     *
     *  @param string $query
     *
     *  @return array
     */
    public static function search(string $query)
    {
        return self::with('address', 'phone', 'phone2', 'phone.type')
                    // ->remember(60 * 60)->prefix(Auth::user()->office_id."_".self::class)
                    ->where('office_id', Auth::user()->office_id)
                    ->where(function ($where) use ($query) {
                        $where->whereRaw('LOWER(name) LIKE "%'.strtolower($query).'%"')
                            ->orWhereRaw('LOWER(email) LIKE "%'.strtolower($query).'%"')
                            ->orWhereRaw('LOWER(identity_document) LIKE "%'.strtolower($query).'%"');
                    })
                    ->orderBy('is_active', 'desc')
                    ->orderBy('name')
                    ->paginate(config('system.paginate'));
    }

    /**
     *  Returns office's active citizens
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
