<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Repositories\ActivityClassRepository;
use App\Repositories\ActivityRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request as HttpRequest;

class ActivityClassController extends Controller
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
        $this->firewall('activity_class');
        return view('logged.activity_class.index');
    }

    /**
     *  Searches for activity class by query
     *
     *  @param string $query
     *
     *  @return View|Factory
     */
    public function search(string $query = '')
    {
        $this->firewall('activity_class');
        $classes = ActivityClassRepository::search($query);
        return view('logged.activity_class.search', compact('classes'));
    }

    /**
     *  Loads insert page
     *
     *  @return View|Factory
     */
    public function create()
    {
        $this->firewall('activity_class.insert');
        $class = false;
        $activities = ActivityRepository::getActives();
        $responsibles = UserRepository::getActives();
        return view('logged.activity_class.form', compact('class', 'activities', 'responsibles'));
    }

    /**
     *  Persists activity class
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return Redirector|RedirectResponse
     */
    public function insert(HttpRequest $httpRequest)
    {
        $this->firewall('activity_class.insert');

        $validated = $httpRequest->validate([
            'activity_id' => ['required'],
            'activity_class_is_active' => ['required'],
            'activity_class_responsible_user_id' => ['required'],
        ]);

        if (ActivityClassRepository::insert($httpRequest)) {
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
        $this->firewall('activity_class.update');

        $class = ActivityClassRepository::find($id);

        if (!$class) {
            return $this->couldntFind();
        }

        $activities = ActivityRepository::getActives();
        $responsibles = UserRepository::getActives();

        return view('logged.activity_class.form', compact('class', 'activities', 'responsibles'));
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
        $this->firewall('activity_class.update');

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
