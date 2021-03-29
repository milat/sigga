<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Address extends Model
{
    /**
     *  @var string
     */
    protected $table = 'addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_type_id',
        'owner_id',
        'postal_code',
        'address',
        'address_type_id',
        'number',
        'extra',
        'neighborhood',
        'city',
        'state',
        'country',
        'note'
    ];

    /**
     *  @return HasOne
     */
    public function type()
    {
        return $this->hasOne(AddressType::class, 'id', 'address_type_id');
    }
}
