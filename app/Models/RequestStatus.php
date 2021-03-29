<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RequestStatus extends Model
{
    /**
     *  @var string
     */
    protected $table = 'request_statuses';

    /**
     *  @return HasMany
     */
    public function requests()
    {
        return $this->hasMany(Request::class, 'status_id', 'id')
                    ->where('office_id', Auth::user()->office_id);
    }

    /**
     *  @return HasMany
     */
    public function monthRequests()
    {
        return $this->requests()
                    ->whereDate('created_at', '>=', Carbon::now()->subMonth());
    }

    /**
     *  @return HasMany
     */
    public function yearRequests()
    {
        return $this->requests()
                    ->whereDate('created_at', '>=', Carbon::now()->subYear());
    }
}
