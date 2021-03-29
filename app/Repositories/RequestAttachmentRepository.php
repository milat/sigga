<?php

namespace App\Repositories;

use App\Models\Request;
use App\Models\RequestAttachment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        $file = $httpRequest->file('attachment_file');
        $extension = $file->getClientOriginalExtension();
        $fileName = $file->getClientOriginalName();
        $path = self::getPath($request->id, $fileName);

        Storage::disk('local')->put($path, file_get_contents($file->getRealPath()));

        $attachment = new RequestAttachment();
        $attachment->request_id = $request->id;
        $attachment->user_id = Auth::user()->id;
        $attachment->title = trim($httpRequest->attachment_title);
        $attachment->file_name = $fileName;
        $attachment->file_extension = $extension;
        $attachment->file_path = $path;

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
        return Storage::download($attachment->file_path, $attachment->file_name);
    }

    /**
     *  Get attachment path based on config/system.php
     *
     *  @param int $requestId
     *  @param string $fileName
     *
     *  @return string
     */
    private static function getPath(int $requestId, string $fileName)
    {
        $path = config('system.request_attachments_path');
        $path = str_replace('<office_id>', Auth::user()->office_id, $path);
        $path = str_replace('<request_id>', $requestId, $path);
        $path = str_replace('<file_name>', time()."_".$fileName, $path);

        return $path;
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
}
