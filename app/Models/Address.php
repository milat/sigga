<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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
        'owner_type',
        'owner_id',
        'code',
        'name',
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

    /**
     *  @return MorphTo
     */
    public function owner() {
        return $this->morphTo();
    }
}
