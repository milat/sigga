<?php

namespace App\Repositories;

use App\Models\Document;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;

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
     *  @return Document|bool
     */
    public static function insert(HttpRequest $httpRequest)
    {
        $document = new Document;
        $file = FileRepository::insert($httpRequest, self::getFilePath());

        $document->office_id = Auth::user()->office_id;
        $document->created_by_user_id = Auth::user()->id;
        $document->file_id = $file->id;

        self::set($document, $httpRequest);

        if ($document->save()) {
            return $document;
        }

        return false;
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
        FileRepository::update($document->file, $httpRequest, self::getFilePath());
        self::set($document, $httpRequest);
        return $document->save();
    }

    /**
     *  Searches for document by code
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return array
     */
    public static function combo(HttpRequest $httpRequest)
    {
        $code = $httpRequest->get('q');
        $combo = [];

        foreach (Document::combo($code) as $document) {
            $combo['results'][] = [
                'id' => $document->id,
                'text' => $document->name." Nº ".$document->code.
                            ", enviado em ".date('d/m/Y', strtotime($document->date)).
                            ": ".substr($document->title, 0, 100).
                            ((strlen($document->title) > 100) ? '[...]' : '')
            ];
        }

        return $combo;
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
        return FileRepository::download($document->file);
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
        $document->updated_by_user_id = Auth::user()->id;
        $document->document_type_id = $httpRequest->document_type_id;
        $document->date = $httpRequest->document_date;
        $document->code = $httpRequest->document_code;
        $document->title = $httpRequest->document_title;
        $document->note = $httpRequest->document_note;
    }

    /**
     *  Returns default file path
     *
     *  @return string
     */
    private static function getFilePath()
    {
        return config('system.documents_path');
    }
}
