<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Repositories\AttachmentRepository;
use Illuminate\Http\Request as HttpRequest;

class AttachmentController extends Controller
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
        $this->firewall('attachment');
        return view('logged.attachment.index');
    }

    /**
     *  Searches for attachment by query
     *
     *  @param string $query
     *
     *  @return View|Factory
     */
    public function search(string $query = '')
    {
        $this->firewall('attachment');
        $attachments = AttachmentRepository::search($query);
        return view('logged.attachment.search', compact('attachments'));
    }

    /**
     *  Loads insert page
     *
     *  @return View|Factory
     */
    public function create()
    {
        $this->firewall('attachment.insert');
        $attachment = false;
        return view('logged.attachment.form', compact('attachment'));
    }

    /**
     *  Persists attachment
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return Redirector|RedirectResponse
     */
    public function insert(HttpRequest $httpRequest)
    {
        $this->firewall('attachment.insert');

        $validated = $httpRequest->validate([
            'attachment_date' => 'required',
            'attachment_title' => ['required'],
            'file' => ['required', 'max:2048', 'mimes:pdf']
        ]);

        if (AttachmentRepository::insert($httpRequest)) {
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
        $this->firewall('attachment.update');

        $attachment = AttachmentRepository::find($id);

        if (!$attachment) {
            return $this->couldntFind();
        }

        return view('logged.attachment.form', compact('attachment'));
    }

    /**
     *  Updates attachment
     *
     *  @param HttpRequest $httpRequest
     *  @param int $id
     *
     *  @return mixed
     */
    public function update(HttpRequest $httpRequest, int $id)
    {
        $this->firewall('attachment.update');

        $validated = $httpRequest->validate([
            'attachment_date' => 'required',
            'attachment_title' => ['required'],
            'file' => ['nullable', 'max:2048', 'mimes:pdf']
        ]);

        $attachment = AttachmentRepository::find($id);

        if (!$attachment) {
            return $this->couldntFind();
        }

        if (AttachmentRepository::update($attachment, $httpRequest)) {
            return $this->hasBeenUpdated();
        }

        return $this->couldntUpdate();
    }

    /**
     *  Downloads attachment file
     *
     *  @param int $id
     *
     *  @return mixed
     */
    public function download(int $id)
    {
        $this->firewall('attachment');

        $attachment = AttachmentRepository::find($id);

        if (!$attachment) {
            return $this->couldntFind();
        }

        return AttachmentRepository::download($attachment);
    }
}
