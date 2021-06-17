<?php

namespace App\Repositories;

use App\Models\ActivityClass;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;

class ActivityClassRepository extends Repository
{
    /**
     *  Finds activity class by id
     *
     *  @param int $id
     *
     *  @return ActivityClass|bool
     */
    public static function find(int $id)
    {
        return self::findIn(ActivityClass::class, $id, false);
    }

    /**
     *  Searches for activity class by query
     *
     *  @param string $query
     *
     *  @return ActivityClass
     */
    public static function search($query)
    {
        return ActivityClass::search($query);
    }

    /**
     *  Persists activity
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return ActivityClass|bool
     */
    public static function insert(HttpRequest $httpRequest)
    {
        $class = new ActivityClass;
        $class->activity_id = $httpRequest->activity_id;
        $class->created_by_user_id = Auth::user()->id;

        self::set($class, $httpRequest);

        if ($class->save()) {
            return $class;
        }

        return false;
    }

    /**
     *  Updates activity class
     *
     *  @param ActivityClass $activityClass
     *  @param HttpRequest $httpRequest
     *
     *  @return bool
     */
    public static function update(ActivityClass $class, HttpRequest $httpRequest)
    {
        self::set($class, $httpRequest);
        return $class->save();
    }

    /**
     *  Sets activity model with HttpRequest
     *
     *  @param Activity $activity
     *  @param HttpRequest $httpRequest
     *
     *  @return void
     */
    private static function set(ActivityClass &$class, HttpRequest $httpRequest)
    {
        $class->updated_by_user_id = Auth::user()->id;
        $class->responsible_user_id = $httpRequest->activity_class_responsible_user_id;
        $class->place = $httpRequest->activity_class_place;
        $class->schedule = $httpRequest->activity_class_schedule;
        $class->max_subscribers = $httpRequest->activity_class_max_subscribers;
        $class->note = $httpRequest->activity_class_note;
        $class->is_active = $httpRequest->activity_class_is_active;
    }
}
