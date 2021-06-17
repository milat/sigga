<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Document extends Model
{
    /**
     *  @var string
     */
    protected $table = 'documents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'office_id',
        'user_id',
        'document_type_id',
        'file_id',
        'date',
        'code',
        'title',
        'created_by_user_id',
        'updated_by_user_id',
        'note'
    ];

    /**
     *  @return HasOne
     */
    public function type()
    {
        return $this->hasOne(DocumentType::class, 'id', 'document_type_id');
    }

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
     *  Searches for document by query
     *
     *  @param string $query
     *
     *  @return array
     */
    public static function search(string $query)
    {
        return self::with('file')
                    ->where('office_id', '=', Auth::user()->office_id)
                    ->where(function ($where) use ($query) {
                        $where->whereRaw('LOWER(code) LIKE "%'.strtolower($query).'%"')
                                ->orWhereRaw('LOWER(title) LIKE "%'.strtolower($query).'%"')
                                ->orWhereRaw('LOWER(date) LIKE "%'.strtolower($query).'%"');
                    })
                    ->orderBy('date', 'desc')
                    ->orderBy('code', 'desc')
                    ->orderBy('title')
                    ->paginate(config('system.paginate'));
    }

    /**
     *  Searches for document to create options combo
     *
     *  @param string $query
     *
     *  @return array
     */
    public static function combo(string $query)
    {
        return self::select('documents.id', 'document_types.name', 'documents.code', 'documents.date', 'documents.title')
                    ->join('document_types', 'document_types.id', '=', 'documents.document_type_id')
                    ->where('documents.office_id', '=', Auth::user()->office_id)
                    ->where(function ($where) use ($query) {
                        $where->whereRaw('LOWER(documents.code) LIKE "%'.strtolower($query).'%"')
                                ->orWhereRaw('LOWER(documents.title) LIKE "%'.strtolower($query).'%"')
                                ->orWhereRaw('LOWER(documents.date) LIKE "%'.strtolower($query).'%"');
                    })
                    ->where('document_types.can_request', true)
                    ->orderBy('documents.document_type_id')
                    ->orderBy('documents.code')
                    ->orderBy('documents.date')
                    ->orderBy('documents.title')
                    ->get();
    }
}
