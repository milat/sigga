<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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
        'owner_type',
        'owner_id',
        'category_id',
        'document_id',
        'status_id',
        'title',
        'description',
        'place',
        'reminder',
        'created_by_user_id',
        'updated_by_user_id'
    ];

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
    public function document()
    {
        return $this->hasOne(Document::class, 'id', 'document_id')
                    ->where('office_id', Auth::user()->office_id);
    }

    /**
     *  @return MorphTo
     */
    public function owner() {
        return $this->morphTo();
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
     *  Searches for request by query
     *
     *  @param string $query
     *  @param int $categoryId
     *  @param int $statusId
     *
     *  @return array
     */
    public static function search(string $query, int $categoryId = null, int $statusId = null)
    {
        $sql = self::select('requests.*')
                    ->join('request_categories', 'request_categories.id', '=', 'requests.category_id')
                    ->leftJoin('citizens', function($leftJoin) {
                        $leftJoin->on('requests.owner_id', '=', 'citizens.id');
                        $leftJoin->where('requests.owner_type', '=', Citizen::class);
                    })
                    ->leftJoin('organizations', function($leftJoin) {
                        $leftJoin->on('requests.owner_id', '=', 'organizations.id');
                        $leftJoin->where('requests.owner_type', '=', Organization::class);
                    })
                    ->leftJoin('users', function($leftJoin) {
                        $leftJoin->on('requests.owner_id', '=', 'users.id');
                        $leftJoin->where('requests.owner_type', '=', User::class);
                    })
                    ->where('requests.office_id', Auth::user()->office_id)
                    ->where(function ($where) use ($query) {
                        self::filter($where, $query);
                    });

        if ($categoryId) {
            $sql->where('category_id', $categoryId);
        }

        if ($statusId) {
            $sql->where('status_id', $statusId);
        }

        return $sql->orderBy('requests.status_id')
                    ->orderBy('requests.created_at', 'desc')
                    ->paginate(config('system.paginate'));
    }

    /**
     *  Returns requests with documents next to its deadlines
     *
     *  @return array
     */
    public static function toWarn()
    {
        return self::select(DB::raw('
                        requests.id as request_id,
                        request_categories.name as category,
                        document_types.name as document_type,
                        documents.code as document_code,
                        documents.date as document_date,
                        COALESCE(citizens.name,organizations.name, users.name) as owner
                    '))
                    ->join('request_categories', 'request_categories.id', '=', 'requests.category_id')
                    ->join('documents', 'documents.id', '=', 'requests.document_id')
                    ->join('document_types', 'document_types.id', '=', 'documents.document_type_id')
                    ->leftJoin('citizens', function($leftJoin) {
                        $leftJoin->on('requests.owner_id', '=', 'citizens.id');
                        $leftJoin->where('requests.owner_type', '=', Citizen::class);
                    })
                    ->leftJoin('organizations', function($leftJoin) {
                        $leftJoin->on('requests.owner_id', '=', 'organizations.id');
                        $leftJoin->where('requests.owner_type', '=', Organization::class);
                    })
                    ->leftJoin('users', function($leftJoin) {
                        $leftJoin->on('requests.owner_id', '=', 'users.id');
                        $leftJoin->where('requests.owner_type', '=', User::class);
                    })
                    ->where('documents.office_id', '=', Auth::user()->office_id)
                    ->where('requests.office_id', '=', Auth::user()->office_id)
                    ->where('document_types.has_deadline', true)
                    ->where('requests.status_id', config('request_statuses.sent.id'))
                    ->whereDate('documents.date', '<=', Carbon::now()->subDays(config('system.document_request_deadline')))
                    ->orderBy('documents.date')
                    ->orderBy('requests.id')
                    ->get();
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
            ->orWhereRaw('LOWER(organizations.name) LIKE "%'.strtolower($query).'%"')
            ->orWhereRaw('LOWER(organizations.contact) LIKE "%'.strtolower($query).'%"')
            ->orWhereRaw('LOWER(organizations.branch) LIKE "%'.strtolower($query).'%"')
            ->orWhereRaw('LOWER(organizations.identity_document) LIKE "%'.strtolower($query).'%"')
            ->orWhereRaw('LOWER(users.name) LIKE "%'.strtolower($query).'%"')
            ->orWhereRaw('LOWER(users.email) LIKE "%'.strtolower($query).'%"');
    }
}
