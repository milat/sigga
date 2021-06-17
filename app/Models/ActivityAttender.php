<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class ActivityAttender extends Model
{
    /**
     *  @var string
     */
    protected $table = 'activity_attenders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lesson_id',
        'subscriber_id',
        'has_came',
        'note',
        'is_active',
        'created_by_user_id',
        'updated_by_user_id'
    ];

    /**
     *  @return HasOne
     */
    public function lesson()
    {
        return $this->hasOne(ActivityLesson::class, 'id', 'lesson_id');
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
}
