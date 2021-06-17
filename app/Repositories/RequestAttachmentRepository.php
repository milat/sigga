<?php

namespace App\Repositories;

use App\Models\Request;
use App\Models\RequestAttachment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request as HttpRequest;

class RequestAttachmentRepository extends Repository
{
    /**
     *  Finds attachment by id
     *
     *  @param int $id
     * 
     *  @return RequestAttachment|bool
     */
    public static function find(int $id)
    {
        $attachment = self::findIn(RequestAttachment::class, $id, false);

        if ($attachment) {
            self::validateAttachmentRequest($attachment);
        }

        return $attachment;
    }

    /**
     *  Persists request attachment
     *
     *  @param Request $request
     *  @param HttpRequest $httpRequest
     *
     *  @return bool
     */
    public static function save(Request $request, HttpRequest $httpRequest)
    {
        $file = FileRepository::insert($httpRequest, self::getFilePath($request->id));

        $attachment = new RequestAttachment();
        $attachment->request_id = $request->id;
        $attachment->created_by_user_id = Auth::user()->id;
        $attachment->title = trim($httpRequest->attachment_title);
        $attachment->file_id = $file->id;

        return $attachment->save();
    }

    /**
     *  Downloads attachment
     *
     *  @param RequestAttachment $attachment
     *
     *  @return mixed
     */
    public static function download(RequestAttachment $attachment)
    {
        return FileRepository::download($attachment->file);
    }

    /**
     *  Check if attachment belongs to office
     *
     *  @param RequestAttachment $attachment
     *
     *  @return boolean
     */
    private static function validateAttachmentRequest(RequestAttachment $attachment)
    {
        if ($attachment->request->office_id != Auth::user()->office_id) {
            abort(403);
        }
    }

    /**
     *  Returns default file path
     *
     *  @param int $requestId
     *
     *  @return string
     */
    private static function getFilePath(int $requestId)
    {
        $path = config('system.request_attachments_path');
        return str_replace('<request_id>', $requestId, $path);
    }
}
