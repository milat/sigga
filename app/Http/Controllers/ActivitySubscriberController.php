<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use App\Models\ActivitySubscriber;
use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Repositories\ActivityRepository;
use Illuminate\Http\Request as HttpRequest;
use App\Repositories\ActivityClassRepository;
use App\Repositories\ActivitySubscriberRepository;
use App\Repositories\CitizenRepository;

class ActivitySubscriberController extends Controller
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
     *  @param $id Class Id
     *
     *  @return View|Factory
     */
    public function index(int $id)
    {
        $this->firewall('activity_subscribe');

        $class = ActivityClassRepository::find($id);

        if (!$class) {
            return $this->couldntFind();
        }

        return view('logged.activity_subscriber.index', compact('class'));
    }

    /**
     *  Searches for activity subscriber by query
     *
     *  @param int $id Class Id
     *  @param string $query
     *
     *  @return View|Factory
     */
    public function search(int $id, string $query = '')
    {
        $this->firewall('activity_subscribe');

        $class = ActivityClassRepository::find($id);

        if (!$class) {
            return $this->couldntFind();
        }

        $subscribers = ActivitySubscriberRepository::search($query, $class->id);
        return view('logged.activity_subscriber.search', compact('subscribers'));
    }

    /**
     *  Loads insert page
     *
     *  @param int $id Class Id
     *
     *  @return View|Factory
     */
    public function create(int $id)
    {
        $this->firewall('activity_subscribe.insert');

        $class = ActivityClassRepository::find($id);

        if (!$class) {
            return $this->couldntFind();
        }

        $nonSubscribers = ActivitySubscriberRepository::getNonSubscribers($class->id);

        return view('logged.activity_subscriber.form', compact('class', 'nonSubscribers'));
    }

    /**
     *  Persists activity subscriber
     *
     *  @param int $id Class id
     *  @param HttpRequest $httpRequest
     *
     *  @return Redirector|RedirectResponse
     */
    public function insert(int $id, HttpRequest $httpRequest)
    {
        $this->firewall('activity_subscribe.insert');

        $class = ActivityClassRepository::find($id);

        if (!$class) {
            return $this->couldntFind();
        }

        $validated = $httpRequest->validate([
            'subscriber_owner' => ['required'],
        ]);

        if (ActivitySubscriberRepository::insert($class->id, $httpRequest)) {
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
        $this->firewall('activity_subscribe.update');

        $class = ActivityClassRepository::find($id);

        if (!$class) {
            return $this->couldntFind();
        }

        $activities = ActivityRepository::getActives();
        $responsibles = UserRepository::getActives();

        return view('logged.activity_subscriber.form', compact('class', 'activities', 'responsibles'));
    }

    /**
     *  Updates activity class
     *
     *  @param HttpRequest $httpRequest
     *  @param int $id
     *
     *  @return mixed
     */
    public function update(HttpRequest $httpRequest, int $id)
    {
        $this->firewall('activity_subscribe.update');

        $validated = $httpRequest->validate([
            'activity_id' => ['required'],
            'activity_class_is_active' => ['required'],
            'activity_class_responsible_user_id' => ['required'],
        ]);

        $class = ActivityClassRepository::find($id);

        if (!$class) {
            return $this->couldntFind();
        }

        if (ActivityClassRepository::update($class, $httpRequest)) {
            return $this->hasBeenUpdated();
        }

        return $this->couldntUpdate();
    }
}
