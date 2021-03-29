<?php

namespace App\Repositories;

use App\Models\Address;
use Illuminate\Http\Request as HttpRequest;

class AddressRepository extends Repository
{
    /**
     *  Persist address
     *
     *  @param HttpRequest $httpRequest
     *  @param int $ownerTypeId
     *  @param int $ownerId
     *
     *  @return bool
     */
    public static function save(HttpRequest $httpRequest, int $ownerTypeId, int $ownerId)
    {
        if (!self::isFilled($httpRequest)) {
            return false;
        }

        $address = self::firstOrNew($ownerTypeId, $ownerId);

        $address->owner_type_id = $ownerTypeId;
        $address->owner_id = $ownerId;
        $address->postal_code = $httpRequest->address_postal_code;
        $address->address = $httpRequest->address_address;
        $address->address_type_id = $httpRequest->address_address_type_id;
        $address->number = $httpRequest->address_number;
        $address->extra = $httpRequest->address_extra;
        $address->neighborhood = $httpRequest->address_neighborhood;
        $address->city = $httpRequest->address_city;
        $address->state = $httpRequest->address_state;

        return $address->save();
    }

    /**
     *  Returns found address or a new instance
     *
     *  @param int $ownerTypeId
     *  @param int $ownerId
     *
     *  @return Address
     */
    private static function firstOrNew(int $ownerTypeId, int $ownerId)
    {
        return Address::where('owner_type_id', $ownerTypeId)
                        ->where('owner_id', $ownerId)
                        ->first()
                        ??
                        new Address();
    }

    /**
     *  Checks if required fields are filled
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return bool
     */
    private static function isFilled(HttpRequest $httpRequest)
    {
        foreach ([
            'address_address',
            'address_address_type_id',
            'address_number',
            'address_neighborhood',
            'address_city',
            'address_state'
        ] as $required) {
            if (!$httpRequest->{$required} || $httpRequest->{$required} == '') {
                return false;
            }
        }

        return true;
    }
}
