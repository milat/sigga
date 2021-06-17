<?php

namespace App\Repositories;

use App\Models\Attachment;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;

class AttachmentRepository extends Repository
{
    /**
     *  Finds attachment by id
     *
     *  @param int $id
     *
     *  @return Attachment|bool
     */
    public static function find(int $id)
    {
        return self::findIn(Attachment::class, $id);
    }

    /**
     *  Searches for attachment by query
     *
     *  @param string $query
     *
     *  @return Attachment
     */
    public static function search($query)
    {
        return Attachment::search($query);
    }

    /**
     *  Persists attachment
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return Attachment|bool
     */
    public static function insert(HttpRequest $httpRequest)
    {
        $attachment = new Attachment;
        $file = FileRepository::insert($httpRequest, self::getFilePath());

        $attachment->office_id = Auth::user()->office_id;
        $attachment->created_by_user_id = Auth::user()->id;
        $attachment->file_id = $file->id;

        self::set($attachment, $httpRequest);

        if ($attachment->save()) {
            return $attachment;
        }

        return false;
    }

    /**
     *  Updated attachment
     *
     *  @param Attachment $attachment
     *  @param HttpRequest $httpRequest
     *
     *  @return bool
     */
    public static function update(Attachment $attachment, HttpRequest $httpRequest)
    {
        FileRepository::update($attachment->file, $httpRequest, self::getFilePath());
        self::set($attachment, $httpRequest);
        return $attachment->save();
    }

    /**
     *  Downloads attachment
     *
     *  @param Attachment $attachment
     *
     *  @return mixed
     */
    public static function download(Attachment $attachment)
    {
        return FileRepository::download($attachment->file);
    }

    /**
     *  Sets attachment model with HttpRequest
     *
     *  @param Attachment $attachment
     *  @param HttpRequest $httpRequest
     *
     *  @return void
     */
    private static function set(Attachment &$attachment, HttpRequest $httpRequest)
    {
        $attachment->updated_by_user_id = Auth::user()->id;
        $attachment->date = $httpRequest->attachment_date;
        $attachment->title = $httpRequest->attachment_title;
        $attachment->note = $httpRequest->attachment_note;
    }

    /**
     *  Returns default file path
     *
     *  @return string
     */
    private static function getFilePath()
    {
        return config('system.attachments_path');
    }
}
