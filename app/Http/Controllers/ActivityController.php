<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Repositories\ActivityRepository;
use Illuminate\Http\Request as HttpRequest;

class ActivityController extends Controller
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
        $this->firewall('activity');
        return view('logged.activity.index');
    }

    /**
     *  Searches for activity by query
     *
     *  @param string $query
     *
     *  @return View|Factory
     */
    public function search(string $query = '')
    {
        $this->firewall('activity');
        $activities = ActivityRepository::search($query);
        return view('logged.activity.search', compact('activities'));
    }

    /**
     *  Loads insert page
     *
     *  @return View|Factory
     */
    public function create()
    {
        $this->firewall('activity.insert');
        $activity = false;
        return view('logged.activity.form', compact('activity'));
    }

    /**
     *  Persists activity
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return Redirector|RedirectResponse
     */
    public function insert(HttpRequest $httpRequest)
    {
        $this->firewall('activity.insert');

        $validated = $httpRequest->validate([
            'activity_name' => ['required', 'max:20'],
            'activity_is_active' => ['required']
        ]);

        if (ActivityRepository::insert($httpRequest)) {
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
        $this->firewall('activity.update');

        $activity = ActivityRepository::find($id);

        if (!$activity) {
            return $this->couldntFind();
        }

        return view('logged.activity.form', compact('activity'));
    }

    /**
     *  Updates activity
     *
     *  @param HttpRequest $httpRequest
     *  @param int $id
     *
     *  @return mixed
     */
    public function update(HttpRequest $httpRequest, int $id)
    {
        $this->firewall('activity.update');

        $validated = $httpRequest->validate([
            'activity_name' => ['required', 'max:20'],
            'activity_is_active' => ['required']
        ]);

        $activity = ActivityRepository::find($id);

        if (!$activity) {
            return $this->couldntFind();
        }

        if (ActivityRepository::update($activity, $httpRequest)) {
            return $this->hasBeenUpdated();
        }

        return $this->couldntUpdate();
    }
}
