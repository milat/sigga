<?php

namespace App\Repositories;

use App\Models\Phone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request as HttpRequest;

class PhoneRepository
{
    /**
     *  Persists main and second (optional) phones
     *
     *  @param HttpRequest $httpRequest
     *  @param Model $owner
     *
     *  @return bool
     */
    public static function save(HttpRequest $httpRequest, Model $owner)
    {
        $main = self::persist($httpRequest, $owner, true);
        $second = self::persist($httpRequest, $owner, false);

        return ($main && ($second || !self::isFilled($httpRequest, false)));
    }

    /**
     *  Persists main phone
     *
     *  @param HttpRequest $httpRequest
     *  @param Model $owner
     *  @param bool $isMain
     *
     *  @return bool
     */
    private static function persist(HttpRequest $httpRequest, Model $owner, bool $isMain)
    {
        if (!self::isFilled($httpRequest, $isMain)) {
            if (!$isMain) {
                self::deleteSecondary($owner);
            }
            return false;
        }

        $phone = self::firstOrNew($owner, $isMain);
        $x = (!$isMain) ? '_2' : '';

        $phone->owner_type = get_class($owner);
        $phone->owner_id = $owner->id;
        $phone->phone_type_id = $httpRequest->{'phone_phone_type_id'.$x};
        $phone->number = $httpRequest->{'phone_number'.$x};
        $phone->note = $httpRequest->{'phone_note'.$x};
        $phone->is_main = $isMain;

        return $phone->save();
    }

    /**
     *  Deletes owners secondary phone
     *
     *  @param Model $owner
     *
     *  @return void
     */
    private static function deleteSecondary(Model $owner)
    {
        Phone::where('owner_type', get_class($owner))
            ->where('owner_id', $owner->id)
            ->where('is_main', false)
            ->delete();
    }

    /**
     *  Returns found phone or a new instance
     *
     *  @param Model $owner
     *  @param bool isMain
     *
     *  @return Phone
     */
    private static function firstOrNew(Model $owner, $isMain = true)
    {
        return Phone::where('owner_type', get_class($owner))
                        ->where('owner_id', $owner->id)
                        ->where('is_main', $isMain)
                        ->first()
                        ??
                        new Phone();
    }

    /**
     *  Checks if required fields are filled
     *
     *  @param HttpRequest $httpRequest
     *  @param bool $isMain
     *
     *  @return bool
     */
    private static function isFilled(HttpRequest $httpRequest, bool $isMain = true)
    {
        $x = (!$isMain) ? '_2' : '';

        foreach ([
            'phone_phone_type_id',
            'phone_number'
        ] as $required) {
            if (!$httpRequest->{$required.$x} || $httpRequest->{$required.$x} == '') {
                return false;
            }
        }

        return true;
    }
}
