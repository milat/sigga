<?php

namespace App\Repositories;

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
     *  @param int $statusId
     *
     *  @return array
     */
    public static function search(string $query = null, int $statusId = null)
    {
        return Request::search($query, $statusId);
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
        $request->owner_type_id = (int) $owner[0];
        $request->owner_id = (int) $owner[1];

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
     *  Sets request model with HttpRequest
     *
     *  @param Request $request
     *  @param HttpRequest $httpRequest
     *
     *  @return void
     */
    private static function set(Request &$request, HttpRequest $httpRequest)
    {
        $request->user_id = Auth::user()->id;
        $request->category_id = $httpRequest->request_category_id;
        $request->status_id = $httpRequest->request_status_id;
        $request->place = $httpRequest->request_place;
        $request->title = $httpRequest->request_title;
        $request->description = $httpRequest->request_description;
        $request->reminder = $httpRequest->request_reminder;
    }
}