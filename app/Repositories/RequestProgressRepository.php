<?php

namespace App\Repositories;

use App\Models\Request;
use App\Models\RequestProgress;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;

class RequestProgressRepository extends Repository
{
    /**
     *  Persists request progress
     *
     *  @param Request $request
     *  @param HttpRequest $httpRequest
     *
     *  @return bool
     */
    public static function save(Request $request, HttpRequest $httpRequest)
    {
        $progress = new RequestProgress();
        $progress->request_id = $request->id;
        $progress->created_by_user_id = Auth::user()->id;
        $progress->description = trim($httpRequest->progress_description);

        return $progress->save();
    }
}
