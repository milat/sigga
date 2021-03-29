<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use App\Utils\Language;
use Illuminate\View\View;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Repositories\CitizenRepository;
use App\Repositories\RequestRepository;
use App\Repositories\OwnerTypeRepository;
use Illuminate\Http\Request as HttpRequest;
use App\Repositories\OrganizationRepository;
use App\Repositories\RequestAttachmentRepository;
use App\Repositories\RequestStatusRepository;
use App\Repositories\RequestCategoryRepository;
use App\Repositories\RequestProgressRepository;

class RequestController extends Controller
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
        $this->firewall('request');
        $status = RequestStatusRepository::getAll();
        return view('logged.request.index', compact('status'));
    }

    /**
     *  Searches for request by params
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return View|Factory
     */
    public function search(HttpRequest $httpRequest)
    {
        $this->firewall('request');
        $query = $httpRequest->get('query') ?? '';
        $statusId = $httpRequest->get('status') ?? null;
        $requests = RequestRepository::search($query, $statusId);
        return view('logged.request.search', compact('requests'));
    }

    /**
     *  Loads insert page
     *
     *  @return View|Factory
     */
    public function create()
    {
        $this->firewall('request.insert');
        $request = false;
        $ownerType = OwnerTypeRepository::requesters();
        $citizens = CitizenRepository::getActives();
        $organizations = OrganizationRepository::getActives();
        $users = UserRepository::getActives();
        $categories = RequestCategoryRepository::getActives();
        $status = RequestStatusRepository::getAll();
        $requester = false;
        $requesterType = false;

        return view(
            'logged.request.create',
            compact(
                'request',
                'ownerType',
                'citizens',
                'organizations',
                'users',
                'categories',
                'status',
                'requester',
                'requesterType'
            )
        );
    }

    /**
     *  Persists request
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return Redirector|RedirectResponse
     */
    public function insert(HttpRequest $httpRequest)
    {
        $this->firewall('request.insert');

        $validated = $httpRequest->validate([
            'request_owner_id' => 'required',
            'request_category_id' => 'required',
            'request_status_id' => 'required',
            'request_title' => ['required', 'max:100'],
            'request_description' => 'required',
            'request_place' => ['nullable', 'max:150'],
        ]);

        $request = RequestRepository::insert($httpRequest);

        if ($request) {
            return redirect()->route('request.view', $request->id)
                    ->with('success', Language::get('insert_success'));
        }

        return $this->couldntInsert();
    }

    /**
     *  Loads view/edit page
     *
     *  @param int $id
     *
     *  @return mixed
     */
    public function view(int $id)
    {
        $this->firewall('request');

        $request = RequestRepository::find($id);

        if (!$request) {
            return $this->couldntFind();
        }

        $citizens = false;
        $organizations = false;
        $users = false;
        $categories = RequestCategoryRepository::getActives();
        $status = RequestStatusRepository::getAll();
        $requester = $request->requester();
        $requesterType = $request->requesterType();

        return view(
            'logged.request.view',
            compact(
                'request',
                'ownerType',
                'citizens',
                'organizations',
                'users',
                'categories',
                'status',
                'requester',
                'requesterType'
            )
        );
    }

    /**
     *  Updates request
     *
     *  @param HttpRequest $httpRequest
     *  @param int $id
     *
     *  @return Redirector|RedirectResponse
     */
    public function update(HttpRequest $httpRequest, int $id)
    {
        $this->firewall('request.update');

        $request = RequestRepository::find($id);

        if (!$request) {
            return $this->couldntFind();
        }

        $validated = $httpRequest->validate([
            'request_category_id' => 'required',
            'request_status_id' => 'required',
            'request_title' => ['required', 'max:100'],
            'request_description' => 'required',
            'request_place' => ['nullable', 'max:150'],
        ]);

        if (RequestRepository::update($request, $httpRequest)) {
            return $this->hasBeenUpdated();
        }

        return $this->couldntUpdate();
    }

    /**
     *  Inserts progress
     *
     *  @param HttpRequest $httpRequest
     *  @param int $id
     *
     *  @return Redirector|RedirectResponse
     */
    public function progress(HttpRequest $httpRequest, int $id)
    {
        $this->firewall('request.update');

        $validated = $httpRequest->validate([
            'progress_description' => 'required'
        ]);

        $request = RequestRepository::find($id);

        if (!$request) {
            return $this->couldntFind();
        }

        $insert = RequestProgressRepository::save($request, $httpRequest);

        if ($insert) {
            return redirect()->route('request.view', $id)
                            ->with('success', Language::get('insert_success'))
                            ->with('tab', 'progress');
        }

        return redirect()->route('request.view', $id)
                            ->withErrors('error', Language::get('insert_error'))
                            ->with('tab', 'progress');
    }

    /**
     *  Inserts attachment
     *
     *  @param HttpRequest $httpRequest
     *  @param int $id
     *
     *  @return Redirector|RedirectResponse
     */
    public function attachment(HttpRequest $httpRequest, int $id)
    {
        $this->firewall('request.update');

        $validated = $httpRequest->validate([
            'attachment_title' => 'required',
            'attachment_file' => 'required'
        ]);

        $request = RequestRepository::find($id);

        if (!$request) {
            return $this->couldntFind();
        }

        $insert = RequestAttachmentRepository::save($request, $httpRequest);

        if ($insert) {
            return redirect()->route('request.view', $id)
                            ->with('success', Language::get('insert_success'))
                            ->with('tab', 'attachment');
        }

        return redirect()->route('request.view', $id)
                            ->withErrors('error', Language::get('insert_error'))
                            ->with('tab', 'attachment');
    }

    /**
     *  Downloads attachment
     *
     *  @param int $id
     *  @param int $attachmentId
     *
     *  @return mixed
     */
    public function download(int $id, int $attachmentId)
    {
        $this->firewall('request');

        $request = RequestRepository::find($id);
        $attachment = RequestAttachmentRepository::find($attachmentId);

        if (!$request || !$attachment) {
            return $this->couldntFind();
        }

        $download = RequestAttachmentRepository::download($attachment);

        if (!$download) {
            return redirect()->back()
                    ->withErrors('error', Language::get('download_error'))
                    ->with('tab', 'attachment');
        }

        return $download;
    }
}
