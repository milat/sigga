<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RequestCategory extends Model
{
    /**
     *  @var string
     */
    protected $table = 'request_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'office_id',
        'name',
        'is_active',
        'colour'
    ];

    /**
     *  @return HasMany
     */
    public function requests()
    {
        return $this->hasMany(Request::class, 'category_id', 'id')
                    ->where('office_id', Auth::user()->office_id);
    }

    /**
     *  @return HasMany
     */
    public function monthRequests()
    {
        return $this->requests()
                    ->whereDate('created_at', '>=', Carbon::now()->subMonth());
    }

    /**
     *  @return HasMany
     */
    public function yearRequests()
    {
        return $this->requests()
                    ->whereDate('created_at', '>=', Carbon::now()->subYear());
    }

    /**
     *  Searches for category by query
     *
     *  @param string $query
     *
     *  @return array
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

    /**
     *  Returns office's active categories
     *
     *  @return array
     */
    public static function getActives()
    {
        return self::with('monthRequests', 'yearRequests')
                    ->where('office_id', Auth::user()->office_id)
                    ->where('is_active', true)
                    ->orderBy('name')->get();
    }
}
