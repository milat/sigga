<?php

namespace App\Repositories;

use App\Models\Office;

abstract class OfficeRepository extends Repository
{
    /**
     *  Get office by id
     *
     *  @param int $id
     *
     *  @return Office|bool
     */
    public static function find(int $id)
    {
        return self::findIn(Office::class, $id);
    }

    /**
     *  TODO
     */
    public static function search(string $query = '')
    {

    }

    
}
