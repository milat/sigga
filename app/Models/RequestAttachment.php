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
        'created_by_user_id',
        'title',
        'file_id'
    ];

    /**
     *  @return HasOne
     */
    public function file()
    {
        return $this->hasOne(File::class, 'id', 'file_id');
    }

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
    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'created_by_user_id');
    }
}
