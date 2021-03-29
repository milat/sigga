<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'user_id',
        'name',
        'identity_document',
        'email',
        'birth',
        'note',
        'is_active'
    ];

    /**
     *  @return int
     */
    public static function getOwnerTypeId()
    {
        return config('owner_types.citizens.id');
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
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')
                    ->where('office_id', Auth::user()->office_id);
    }

    /**
     *  @return HasOne
     */
    public function address()
    {
        return $this->hasOne(Address::class, 'owner_id', 'id')
                    ->where('owner_type_id', $this->type->id);
    }

    /**
     *  @return hasOne
     */
    public function phone()
    {
        return $this->hasOne(Phone::class, 'owner_id', 'id')
                    ->where('owner_type_id', $this->type->id)
                    ->where('is_main', true);
    }

    /**
     *  @return hasOne
     */
    public function phone2()
    {
        return $this->hasOne(Phone::class, 'owner_id', 'id')
                    ->where('owner_type_id', $this->type->id)
                    ->where('is_main', false);
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
        return self::with('user')
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
