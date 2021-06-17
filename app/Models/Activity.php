<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
     *  @var string
     */
    protected $table = 'activities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'office_id',
        'name',
        'description',
        'note',
        'is_active',
        'created_by_user_id',
        'updated_by_user_id'
    ];

    /**
     *  @return HasOne
     */
    public function office()
    {
        return $this->hasOne(Office::class, 'id', 'office_id');
    }

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
     *  Search office's activities by query
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
                            ->orWhereRaw('LOWER(description) LIKE "%'.strtolower($query).'%"');
                    })
                    ->orderBy('is_active', 'desc')
                    ->orderBy('name')
                    ->paginate(config('system.paginate'));
    }

    /**
     *  Returns office's active activities
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
