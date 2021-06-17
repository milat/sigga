<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class ActivitySubscriber extends Model
{
    /**
     *  @var string
     */
    protected $table = 'activity_subscribers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'class_id',
        'owner_type',
        'owner_id',
        'is_active',
        'created_by_user_id',
        'updated_by_user_id'
    ];

    /**
     *  @return HasOne
     */
    public function class()
    {
        return $this->hasOne(ActivityClass::class, 'id', 'class_id');
    }

    /**
     *  @return MorphTo
     */
    public function owner() {
        return $this->morphTo();
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
     *  Searches for subscriber by query
     *
     *  @param string $query
     *  @param int $classId
     *
     *  @return array
     */
    public static function search(string $query, int $classId)
    {
        $sql = self::select('activity_subscribers.*')
                    ->join('activity_classes', 'activity_subscribers.class_id', '=', 'activity_classes.id')
                    ->leftJoin('citizens', function($leftJoin) {
                        $leftJoin->on('activity_subscribers.owner_id', '=', 'citizens.id');
                        $leftJoin->where('activity_subscribers.owner_type', '=', Citizen::class);
                    })
                    ->leftJoin('dependents', function($leftJoin) {
                        $leftJoin->on('activity_subscribers.owner_id', '=', 'dependents.id');
                        $leftJoin->where('activity_subscribers.owner_type', '=', Dependent::class);
                    })
                    ->where('activity_classes.id', $classId)
                    ->where(function ($where) use ($query) {
                        $where->whereRaw('LOWER(citizens.name) LIKE "%'.strtolower($query).'%"')
                            ->orWhereRaw('LOWER(citizens.identity_document) LIKE "%'.strtolower($query).'%"')
                            ->orWhereRaw('LOWER(dependents.name) LIKE "%'.strtolower($query).'%"')
                            ->orWhereRaw('LOWER(dependents.identity_document) LIKE "%'.strtolower($query).'%"');
                    });

        return $sql->orderBy('activity_subscribers.is_active', 'desc')
                    ->paginate(config('system.paginate'));
    }

    /**
     *  @return int
     */
    public static function exists(int $classId, string $ownerType, int $ownerId)
    {
        return self::where('class_id', $classId)
                    ->where('owner_type', $ownerType)
                    ->where('owner_id', $ownerId)
                    ->count();
    }
}
