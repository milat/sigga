<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     *  @var string
     */
    protected $table = 'files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'office_id',
        'name',
        'extension',
        'path',
    ];
}
