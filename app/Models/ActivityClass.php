<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ActivityClass extends Model
{
    /**
     *  @var string
     */
    protected $table = 'activity_classes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'activity_id',
        'responsible_user_id',
        'place',
        'schedule',
        'max_subscribers',
        'note',
        'is_active',
        'created_by_user_id',
        'updated_by_user_id'
    ];

    /**
     *  @return HasOne
     */
    public function activity()
    {
        return $this->hasOne(Activity::class, 'id', 'activity_id');
    }

    /**
     *  @return HasOne
     */
    public function responsible()
    {
        return $this->hasOne(User::class, 'id', 'responsible_user_id')
                    ->where('office_id', Auth::user()->office_id);
    }

    /**
     *  @return HasMany
     */
    public function lessons()
    {
        return $this->hasMany(ActivityLesson::class, 'class_id', 'id');
    }

    /**
     *  @return HasMany
     */
    public function subscribers()
    {
        return $this->hasMany(ActivitySubscriber::class, 'class_id', 'id');
    }

    /**
     *  @return HasMany
     */
    public function activeSubscribers()
    {
        return $this->hasMany(ActivitySubscriber::class, 'class_id', 'id')
                    ->where('is_active', true);
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
     *  Searches for class by query
     *
     *  @param string $query
     *
     *  @return array
     */
    public static function search(string $query)
    {
        $sql = self::select('activity_classes.*')
                    ->join('activities', 'activities.id', '=', 'activity_classes.activity_id')
                    ->where('activities.office_id', Auth::user()->office_id)
                    ->where(function ($where) use ($query) {
                        $where->whereRaw('LOWER(activities.name) LIKE "%'.strtolower($query).'%"')
                            ->orWhereRaw('LOWER(activities.description) LIKE "%'.strtolower($query).'%"')
                            ->orWhereRaw('LOWER(activity_classes.place) LIKE "%'.strtolower($query).'%"')
                            ->orWhereRaw('LOWER(activity_classes.schedule) LIKE "%'.strtolower($query).'%"');
                    });

        return $sql->orderBy('activities.is_active')
                    ->orderBy('activities.name')
                    ->paginate(config('system.paginate'));
    }
}
