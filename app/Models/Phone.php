<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Phone extends Model
{
    /**
     *  @var string
     */
    protected $table = 'phones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_type_id',
        'owner_id',
        'phone_type_id',
        'number',
        'note',
        'is_main'
    ];

    /**
     *  @return HasOne
     */
    public function type()
    {
        return $this->hasOne(PhoneType::class, 'id', 'phone_type_id');
    }
}
