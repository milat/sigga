<?php

namespace App\Repositories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request as HttpRequest;

class AddressRepository extends Repository
{
    /**
     *  Persist address
     *
     *  @param HttpRequest $httpRequest
     *  @param Model $owner
     *
     *  @return bool
     */
    public static function save(HttpRequest $httpRequest, Model $owner)
    {
        if (!self::isFilled($httpRequest)) {
            return false;
        }

        $address = self::firstOrNew($owner);

        $address->owner_type = get_class($owner);
        $address->owner_id = $owner->id;
        $address->code = $httpRequest->address_code;
        $address->name = $httpRequest->address_name;
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
     *  @param Model $owner
     *
     *  @return Address
     */
    private static function firstOrNew(Model $owner)
    {
        return Address::where('owner_type', get_class($owner))
                        ->where('owner_id', $owner->id)
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
            'address_name',
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
