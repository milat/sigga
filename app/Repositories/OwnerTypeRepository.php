<?php

namespace App\Repositories;

use App\Models\OwnerType;

class OwnerTypeRepository extends Repository
{
    /**
     *  Load owner types that can request
     *
     *  @return array
     */
    public static function requesters()
    {
        return OwnerType::requesters();
    }
}
