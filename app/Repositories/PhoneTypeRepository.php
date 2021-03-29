<?php

namespace App\Repositories;

use App\Models\PhoneType;

class PhoneTypeRepository extends Repository
{
    /**
     *  Get all phone types
     *
     *  @return array
     */
    public static function all()
    {
        return PhoneType::all();
    }
}
