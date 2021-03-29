<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Request extends Model
{
    /**
     *  @var string
     */
    protected $table = 'requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'office_id',
        'user_id',
        'owner_type_id',
        'owner_id',
        'category_id',
        'status_id',
        'title',
        'description',
        'place',
        'reminder'
    ];

    /**
     *  @return HasOne
     */
    public function type()
    {
        return $this->hasOne(OwnerType::class, 'id', 'owner_type_id');
    }

    /**
     *  @return HasOne
     */
    public function responsible()
    {
        return $this->hasOne(User::class, 'id', 'user_id')
                    ->where('office_id', Auth::user()->office_id);
    }

    /**
     *  @return HasOne
     */
    public function category()
    {
        return $this->hasOne(RequestCategory::class, 'id', 'category_id')
                    ->where('office_id', Auth::user()->office_id);
    }

    /**
     *  @return HasOne
     */
    public function citizen()
    {
        return $this->hasOne(Citizen::class, 'id', 'owner_id')
                    ->where('owner_type_id', $this->type->id);
    }

    /**
     *  @return HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'owner_id')
                    ->where('owner_type_id', $this->type->id);
    }

    /**
     *  @return HasOne
     */
    public function organization()
    {
        return $this->hasOne(Organization::class, 'id', 'owner_id')
                    ->where('owner_type_id', $this->type->id);
    }

    /**
     *  @return HasOne
     */
    public function status()
    {
        return $this->hasOne(RequestStatus::class, 'id', 'status_id');
    }

    /**
     *  @return HasMany
     */
    public function progresses()
    {
        return $this->hasMany(RequestProgress::class, 'request_id', 'id')
                    ->orderBy('created_at', 'desc');
    }

    /**
     *  @return HasMany
     */
    public function attachments()
    {
        return $this->hasMany(RequestAttachment::class, 'request_id', 'id')
                    ->orderBy('created_at', 'desc');
    }

    /**
     *  @return string
     */
    public function requester()
    {
        if ($this->citizen) {
            return $this->citizen->name;
        } elseif ($this->organization) {
            return $this->organization->trade;
        }

        return $this->user->name;
    }

    /**
     *  @return string
     */
    public function requesterType()
    {
        if ($this->citizen) {
            return $this->citizen->type->name;
        } elseif ($this->organization) {
            return $this->organization->type->name;
        }

        return $this->user->type->name;
    }

    /**
     *  Searches for request by query
     *
     *  @param string $query
     *  @param int $statusId
     *
     *  @return array
     */
    public static function search(string $query, int $statusId = null)
    {
        $sql = self::select('requests.*')
                    ->join('request_categories', 'request_categories.id', '=', 'requests.category_id')
                    ->leftJoin('citizens', function ($join) {
                        $join->on('citizens.id', '=', 'requests.owner_id');
                        $join->on('citizens.owner_type_id', '=', 'requests.owner_type_id');
                    })
                    ->leftJoin('organizations', function ($join) {
                        $join->on('organizations.id', '=', 'requests.owner_id');
                        $join->on('organizations.owner_type_id', '=', 'requests.owner_type_id');
                    })
                    ->leftJoin('users', function ($join) {
                        $join->on('users.id', '=', 'requests.owner_id');
                        $join->on('users.owner_type_id', '=', 'requests.owner_type_id');
                    })
                    ->where('requests.office_id', Auth::user()->office_id)
                    ->where(function ($where) use ($query) {
                        self::filter($where, $query);
                    });

        if ($statusId) {
            $sql->where('status_id', $statusId);
        }

        return $sql->orderBy('requests.status_id')
                    ->orderBy('requests.created_at', 'desc')
                    ->paginate(config('system.paginate'));
    }

    /**
     *  Filters the search
     *
     *  @param mixed $where
     *  @param string $query
     *
     *  @return void
     */
    private static function filter(&$where, $query)
    {
        $where->whereRaw('LOWER(requests.title) LIKE "%'.strtolower($query).'%"')
            ->orWhereRaw('LOWER(requests.place) LIKE "%'.strtolower($query).'%"')
            ->orWhereRaw('LOWER(requests.description) LIKE "%'.strtolower($query).'%"')
            ->orWhereRaw('LOWER(citizens.name) LIKE "%'.strtolower($query).'%"')
            ->orWhereRaw('LOWER(citizens.identity_document) LIKE "%'.strtolower($query).'%"')
            ->orWhereRaw('LOWER(organizations.trade) LIKE "%'.strtolower($query).'%"')
            ->orWhereRaw('LOWER(organizations.name) LIKE "%'.strtolower($query).'%"')
            ->orWhereRaw('LOWER(organizations.contact) LIKE "%'.strtolower($query).'%"')
            ->orWhereRaw('LOWER(organizations.branch) LIKE "%'.strtolower($query).'%"')
            ->orWhereRaw('LOWER(organizations.identity_document) LIKE "%'.strtolower($query).'%"')
            ->orWhereRaw('LOWER(users.name) LIKE "%'.strtolower($query).'%"')
            ->orWhereRaw('LOWER(users.email) LIKE "%'.strtolower($query).'%"');
    }
}
