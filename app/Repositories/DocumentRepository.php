<?php

namespace App\Repositories;

use App\Models\Document;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentRepository extends Repository
{
    /**
     *  Finds document by id
     *
     *  @param int $id
     *
     *  @return Document|bool
     */
    public static function find(int $id)
    {
        return self::findIn(Document::class, $id);
    }

    /**
     *  Searches for document by query
     *
     *  @param string $query
     *
     *  @return Document
     */
    public static function search($query)
    {
        return Document::search($query);
    }

    /**
     *  Persists document
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return bool
     */
    public static function insert(HttpRequest $httpRequest)
    {
        $document = new Document;
        $document->office_id = Auth::user()->office_id;
        self::set($document, $httpRequest);
        self::setFile($document, $httpRequest);

        return $document->save();
    }

    /**
     *  Updated document
     *
     *  @param Document $document
     *  @param HttpRequest $httpRequest
     *
     *  @return bool
     */
    public static function update(Document $document, HttpRequest $httpRequest)
    {
        self::set($document, $httpRequest);
        self::setFile($document, $httpRequest);

        return $document->save();
    }

    /**
     *  Downloads document
     *
     *  @param Document $document
     *
     *  @return mixed
     */
    public static function download(Document $document)
    {
        return Storage::download($document->file_path, $document->file_name);
    }

    /**
     *  Sets document model with HttpRequest
     *
     *  @param Document $document
     *  @param HttpRequest $httpRequest
     *
     *  @return void
     */
    private static function set(Document &$document, HttpRequest $httpRequest)
    {
        $document->user_id = Auth::user()->id;
        $document->document_type_id = $httpRequest->document_type_id;
        $document->date = $httpRequest->document_date;
        $document->code = $httpRequest->document_code;
        $document->title = $httpRequest->document_title;
        $document->note = $httpRequest->document_note;
    }

    /**
     *  Sets and persist document file
     *
     *  @param Document $document
     *  @param HttpRequest $httpRequest
     *
     *  @return void
     */
    private static function setFile(Document &$document, HttpRequest $httpRequest)
    {
        if ($httpRequest->hasFile('document_file')) {

            $oldPath = $document->file_path;

            $file = $httpRequest->file('document_file');
            $extension = $file->getClientOriginalExtension();
            $fileName = $file->getClientOriginalName();
            $path = self::getPath($fileName);

            Storage::disk('local')->put($path, file_get_contents($file->getRealPath()));

            $document->file_name = $fileName;
            $document->file_extension = $extension;
            $document->file_path = $path;

            if ($oldPath) {
                Storage::disk('local')->delete($oldPath);
            }

        }
    }

    /**
     *  Get document path based on config/system.php
     *
     *  @param string $fileName
     *
     *  @return string
     */
    private static function getPath(string $fileName)
    {
        $path = config('system.documents_path');
        $path = str_replace('<office_id>', Auth::user()->office_id, $path);
        $path = str_replace('<file_name>', time()."_".$fileName, $path);

        return $path;
    }
}
