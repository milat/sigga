<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RequestAttachment extends Model
{
    /**
     *  @var string
     */
    protected $table = 'request_attachments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'request_id',
        'user_id',
        'title',
        'file_name',
        'file_extension',
        'file_path',
    ];

    /**
     *  @return HasOne
     */
    public function request()
    {
        return $this->hasOne(Request::class, 'id', 'request_id');
    }

    /**
     *  @return HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
