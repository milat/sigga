<?php

namespace App\Repositories;

use App\Models\Document;
use App\Models\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;

class RequestRepository extends Repository
{
    /**
     *  Finds request by id
     *
     *  @param int $id
     *
     *  @return Request|bool
     */
    public static function find(int $id)
    {
        return self::findIn(Request::class, $id);
    }

    /**
     *  Searches for request by query and/or status
     *
     *  @param string $query
     *  @param int $categoryId
     *  @param int $statusId
     *
     *  @return array
     */
    public static function search(string $query = null, int $categoryId = null, int $statusId = null)
    {
        return Request::search($query, $categoryId, $statusId);
    }

    /**
     *  Persists request
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return Request|bool
     */
    public static function insert(HttpRequest $httpRequest)
    {
        $owner = explode("_", $httpRequest->request_owner_id);

        $request = new Request();

        $request->office_id = Auth::user()->office_id;
        $request->owner_type = (int) $owner[0];
        $request->owner_id = (int) $owner[1];
        $request->created_by_user_id = Auth::user()->id;

        self::set($request, $httpRequest);

        if ($request->save()) {
            return $request;
        }

        return false;
    }

    /**
     *  Updates request
     *
     *  @param Request $request
     *  @param HttpRequest $httpRequest
     *
     *  @return Solicitacao|bool
     */
    public static function update(Request $request, HttpRequest $httpRequest)
    {
        self::set($request, $httpRequest);
        return $request->save();
    }

    /**
     *  Updates request
     *
     *  @param Request $request
     *  @param Document $document
     *  @param HttpRequest $httpRequest
     *
     *  @return bool
     */
    public static function link(Request $request, Document $document, HttpRequest $httpRequest)
    {
        $request->document_id = $document->id;
        if ($httpRequest->update_status) {
            $request->status_id = config('request_statuses.sent.id');
        }
        return $request->save();
    }

    /**
     *  Returns requests with documents next to its deadlines
     *
     *  @return array
     */
    public static function toWarn()
    {
        return Request::toWarn();
    }

    /**
     *  Sets request model with HttpRequest
     *
     *  @param Request $request
     *  @param HttpRequest $httpRequest
     *
     *  @return void
     */
    private static function set(Request &$request, HttpRequest $httpRequest)
    {
        $request->updated_by_user_id = Auth::user()->id;
        $request->category_id = $httpRequest->request_category_id;
        $request->status_id = $httpRequest->request_status_id;
        $request->place = $httpRequest->request_place;
        $request->title = $httpRequest->request_title;
        $request->description = $httpRequest->request_description;
        $request->reminder = $httpRequest->request_reminder;
    }
}
