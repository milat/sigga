<?php

namespace App;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnerType extends Model
{
    /**
     *  @var string
     */
    protected $table = 'owner_types';

    /**
     *  Load owner types that can request
     *
     *  @return array
     */
    public static function requesters()
    {
        return self::where('can_request', true)
                    ->orderBy('name')
                    ->get();
    }
}
