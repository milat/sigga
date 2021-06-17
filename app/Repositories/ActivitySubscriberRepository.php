<?php

namespace App\Repositories;

use App\Models\Citizen;
use App\Utils\Language;
use App\Models\Dependent;
use App\Models\ActivityClass;
use App\Models\ActivitySubscriber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request as HttpRequest;

class ActivitySubscriberRepository extends Repository
{
    /**
     *  Finds activity subscriber by id
     *
     *  @param int $id
     *
     *  @return ActivitySubscriber|bool
     */
    public static function find(int $id)
    {
        return self::findIn(ActivitySubscriber::class, $id, false);
    }

    /**
     *  Searches for activity subscriber by query
     *
     *  @param string $query
     *  @param int $classId
     *
     *  @return ActivitySubscriber
     */
    public static function search(string $query, int $classId)
    {
        return ActivitySubscriber::search($query, $classId);
    }

    /**
     *
     */
    public static function getNonSubscribers(int $classId)
    {
        $nonSubscribers = [];

        foreach (CitizenRepository::getActives() as $citizen) {
            if (!ActivitySubscriber::exists($classId, Citizen::class, $citizen->id)) {
                $nonSubscribers[Citizen::class.'_'.$citizen->id] = $citizen->name." ".$citizen->identity_document;
            }

            foreach ($citizen->dependents as $dependent) {
                if (!ActivitySubscriber::exists($classId, Dependent::class, $dependent->id)) {
                    $nonSubscribers[Dependent::class.'_'.$dependent->id] = $dependent->name." ".$dependent->identity_document." (".Language::get('dependent')." ".$citizen->name." ".$citizen->identity_document.")";
                }
            }
        }

        return $nonSubscribers;
    }

    /**
     *  Persists activity subscriber
     *
     *  @param int $classId
     *  @param HttpRequest $httpRequest
     *
     *  @return ActivityClass|bool
     */
    public static function insert(int $classId, HttpRequest $httpRequest)
    {
        $subscriber = new ActivitySubscriber;
        $subscriber->class_id = $classId;
        $subscriber->created_by_user_id = Auth::user()->id;
        $subscriber->updated_by_user_id = Auth::user()->id;
        $subscriber->is_active = true;

        $owner = explode('_', $httpRequest->subscriber_owner);

        $subscriber->owner_type = $owner[0];
        $subscriber->owner_id = $owner[1];

        if ($subscriber->save()) {
            return $subscriber;
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
        return $class->save();
    }
}
