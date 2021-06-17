<?php

namespace App\Models;

use App\Utils\Functions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Dependent extends Model
{
    /**
     *  @var string
     */
    protected $table = 'dependents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'citizen_id',
        'name',
        'identity_document',
        'birth',
        'note',
        'is_active',
        'created_by_user_id',
        'updated_by_user_id'
    ];

    /**
     *  @return int
     */
    public function age()
    {
        return Functions::age($this->birth);
    }

    /**
     *  @return HasOne
     */
    public function citizen()
    {
        return $this->hasOne(Citizen::class, 'id', 'citizen_id');
    }

    /**
     *  @return HasOne
     */
    public function phone()
    {
        return $this->hasOne(Phone::class, 'owner_id', 'id')
                    ->where('owner_type', self::class)
                    ->where('is_main', true);
    }

    /**
     *  @return HasOne
     */
    public function phone2()
    {
        return $this->hasOne(Phone::class, 'owner_id', 'id')
                    ->where('owner_type', self::class)
                    ->where('is_main', false);
    }

    /**
     *  @return HasOne
     */
    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'created_by_user_id')
                    ->where('office_id', Auth::user()->office_id);
    }

    /**
     *  @return HasOne
     */
    public function updater()
    {
        return $this->hasOne(User::class, 'id', 'updated_by_user_id')
                    ->where('office_id', Auth::user()->office_id);
    }
}
