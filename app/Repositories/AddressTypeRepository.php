<?php

namespace App\Repositories;

use App\Models\AddressType;

class AddressTypeRepository extends Repository
{
    /**
     *  Get all address types
     *
     *  @return array
     */
    public static function all()
    {
        return AddressType::all();
    }
}
