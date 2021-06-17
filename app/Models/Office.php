<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    /**
     *  @var string
     */
    protected $table = 'offices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'party',
        'note',
        'is_active'
    ];
}
