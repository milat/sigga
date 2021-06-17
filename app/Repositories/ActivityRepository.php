<?php

namespace App\Repositories;

use App\Models\Activity;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;

class ActivityRepository extends Repository
{
    /**
     *  Finds activity by id
     *
     *  @param int $id
     *
     *  @return Activity|bool
     */
    public static function find(int $id)
    {
        return self::findIn(Activity::class, $id);
    }

    /**
     *  Searches for activity by query
     *
     *  @param string $query
     *
     *  @return Activity
     */
    public static function search($query)
    {
        return Activity::search($query);
    }

    /**
     *  Persists activity
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return Activity|bool
     */
    public static function insert(HttpRequest $httpRequest)
    {
        $activity = new Activity;

        $activity->office_id = Auth::user()->office_id;
        $activity->created_by_user_id = Auth::user()->id;

        self::set($activity, $httpRequest);

        if ($activity->save()) {
            return $activity;
        }

        return false;
    }

    /**
     *  Updates activity
     *
     *  @param Activity $activity
     *  @param HttpRequest $httpRequest
     *
     *  @return bool
     */
    public static function update(Activity $activity, HttpRequest $httpRequest)
    {
        self::set($activity, $httpRequest);
        return $activity->save();
    }

    public static function getActives()
    {
        return Activity::getActives();
    }

    /**
     *  Sets activity model with HttpRequest
     *
     *  @param Activity $activity
     *  @param HttpRequest $httpRequest
     *
     *  @return void
     */
    private static function set(Activity &$activity, HttpRequest $httpRequest)
    {
        $activity->updated_by_user_id = Auth::user()->id;
        $activity->name = $httpRequest->activity_name;
        $activity->description = $httpRequest->activity_description;
        $activity->note = $httpRequest->activity_note;
        $activity->is_active = $httpRequest->activity_is_active;
    }
}
