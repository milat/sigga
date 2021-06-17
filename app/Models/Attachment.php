<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    /**
     *  @var string
     */
    protected $table = 'attachments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'office_id',
        'file_id',
        'date',
        'title',
        'note',
        'created_by_user_id',
        'updated_by_user_id'
    ];

    /**
     *  @return HasOne
     */
    public function file()
    {
        return $this->hasOne(File::class, 'id', 'file_id');
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
     *  Searches for attachment by query
     *
     *  @param string $query
     *
     *  @return array
     */
    public static function search(string $query)
    {
        return self::with('file')
                    ->where('office_id', '=', Auth::user()->office_id)
                    ->where(function ($where) use ($query) {
                        $where->whereRaw('LOWER(title) LIKE "%'.strtolower($query).'%"')
                            ->orWhereRaw('LOWER(date) LIKE "%'.strtolower($query).'%"');
                    })
                    ->orderBy('date', 'desc')
                    ->orderBy('title')
                    ->paginate(config('system.paginate'));
    }
}
