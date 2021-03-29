<?php

namespace App\Repositories;

use App\Models\Phone;
use Illuminate\Http\Request as HttpRequest;

class PhoneRepository
{
    /**
     *  Persists main and second (optional) phones
     *
     *  @param HttpRequest $httpRequest
     *  @param int $ownerTypeId
     *  @param int $ownerId
     *
     *  @return bool
     */
    public static function save(HttpRequest $httpRequest, int $ownerTypeId, int $ownerId)
    {
        $main = self::persist($httpRequest, $ownerTypeId, $ownerId, true);
        $second = self::persist($httpRequest, $ownerTypeId, $ownerId, false);

        return ($main && ($second || !self::isFilled($httpRequest, false)));
    }

    /**
     *  Persists main phone
     *
     *  @param HttpRequest $httpRequest
     *  @param int $ownerTypeId
     *  @param int $ownerId
     *
     *  @return bool
     */
    private static function persist(HttpRequest $httpRequest, int $ownerTypeId, int $ownerId, bool $isMain)
    {
        if (!self::isFilled($httpRequest, $isMain)) {
            return false;
        }

        $phone = self::firstOrNew($ownerTypeId, $ownerId, $isMain);
        $x = (!$isMain) ? '_2' : '';

        $phone->owner_type_id = $ownerTypeId;
        $phone->owner_id = $ownerId;
        $phone->phone_type_id = $httpRequest->{'phone_phone_type_id'.$x};
        $phone->number = $httpRequest->{'phone_number'.$x};
        $phone->note = $httpRequest->{'phone_note'.$x};
        $phone->is_main = $isMain;

        return $phone->save();
    }

    /**
     *  Returns found phone or a new instance
     *
     *  @param int $ownerTypeId
     *  @param int $ownerId
     *  @param bool isMain
     *
     *  @return Phone
     */
    private static function firstOrNew($ownerTypeId, $ownerId, $isMain = true)
    {
        return Phone::where('owner_type_id', $ownerTypeId)
                        ->where('owner_id', $ownerId)
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
