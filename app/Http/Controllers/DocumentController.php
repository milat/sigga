<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Repositories\DocumentRepository;
use Illuminate\Http\Request as HttpRequest;
use App\Repositories\DocumentTypeRepository;

class DocumentController extends Controller
{
    /**
     *  Create a new controller instance.
     *
     *  @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *  Loads index
     *
     *  @return View|Factory
     */
    public function index()
    {
        $this->firewall('document');
        return view('logged.document.index');
    }

    /**
     *  Searches for document by query
     *
     *  @param string $query
     *
     *  @return View|Factory
     */
    public function search(string $query = '')
    {
        $this->firewall('document');
        $documents = DocumentRepository::search($query);
        return view('logged.document.search', compact('documents'));
    }

    /**
     *  Loads insert page
     *
     *  @return View|Factory
     */
    public function create()
    {
        $this->firewall('document.insert');
        $document = false;
        $types = DocumentTypeRepository::all();
        return view('logged.document.form', compact('document', 'types'));
    }

    /**
     *  Persists document
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return Redirector|RedirectResponse
     */
    public function insert(HttpRequest $httpRequest)
    {
        $this->firewall('document.insert');

        $validated = $httpRequest->validate([
            'document_code' => ['required', 'max:20'],
            'document_type_id' => 'required',
            'document_date' => 'required',
            'document_title' => ['required'],
            'file' => ['required', 'max:2048', 'mimes:pdf']
        ]);

        if (DocumentRepository::insert($httpRequest)) {
            return $this->hasBeenInserted();
        }

        return $this->couldntInsert();
    }

    /**
     *  Loads edit page
     *
     *  @param int $id
     *
     *  @return mixed
     */
    public function edit(int $id)
    {
        $this->firewall('document.update');

        $document = DocumentRepository::find($id);

        if (!$document) {
            return $this->couldntFind();
        }

        $types = DocumentTypeRepository::all();

        return view('logged.document.form', compact('document', 'types'));
    }

    /**
     *  Updates document
     *
     *  @param HttpRequest $httpRequest
     *  @param int $id
     *
     *  @return mixed
     */
    public function update(HttpRequest $httpRequest, int $id)
    {
        $this->firewall('document.update');

        $validated = $httpRequest->validate([
            'document_code' => ['required', 'max:20'],
            'document_type_id' => 'required',
            'document_date' => 'required',
            'document_title' => ['required'],
            'file' => ['nullable', 'max:2048', 'mimes:pdf']
        ]);

        $document = DocumentRepository::find($id);

        if (!$document) {
            return $this->couldntFind();
        }

        if (DocumentRepository::update($document, $httpRequest)) {
            return $this->hasBeenUpdated();
        }

        return $this->couldntUpdate();
    }

    /**
     *  Searches for document by code
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return JsonResponse
     */
    public function combo(HttpRequest $httpRequest)
    {
        $combo = DocumentRepository::combo($httpRequest);
        return response()->json($combo);
    }

    /**
     *  Downloads document file
     *
     *  @param int $id
     *
     *  @return mixed
     */
    public function download(int $id)
    {
        $this->firewall('document');

        $document = DocumentRepository::find($id);

        if (!$document) {
            return $this->couldntFind();
        }

        return DocumentRepository::download($document);
    }
}
