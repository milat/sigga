<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Repositories\CitizenRepository;
use App\Repositories\DependentRepository;
use App\Repositories\PhoneTypeRepository;
use Illuminate\Http\Request as HttpRequest;

class DependentController extends Controller
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
     *  Loads citizen index
     *
     *  @param int $citizenId
     *
     *  @return View|Factory
     */
    public function index(int $citizenId)
    {
        $this->firewall('citizen');

        $citizen = CitizenRepository::find($citizenId);

        if (!$citizen) {
            return $this->couldntFind();
        }

        return view(
            'logged.citizen.dependent.index',
            compact(
                'citizen'
            )
        );
    }

    /**
     *  Loads insert page
     *
     *  @param int $citizenId
     *
     *  @return View|Factory
     */
    public function create(int $citizenId)
    {
        $this->firewall('citizen.insert');

        $citizen = CitizenRepository::find($citizenId);

        if (!$citizen) {
            return $this->couldntFind();
        }

        $dependent = false;
        $phone = false;
        $phone2 = false;
        $phoneRequired = false;
        $phoneType = PhoneTypeRepository::all();

        return view(
            'logged.citizen.dependent.form',
            compact(
                'citizen',
                'dependent',
                'phone',
                'phone2',
                'phoneRequired',
                'phoneType'
            )
        );
    }

    /**
     *  Persists citizen
     *
     *  @param HttpRequest $httpRequest
     *  @param int $citizenId
     *
     *  @return Redirector|RedirectResponse
     */
    public function insert(HttpRequest $httpRequest, int $citizenId)
    {
        $this->firewall('citizen.insert');

        $citizen = CitizenRepository::find($citizenId);

        if (!$citizen) {
            return $this->couldntFind();
        }

        $validated = $httpRequest->validate([
            'dependent_name' => ['required', 'max:100'],
            'phone_number' => ['nullable', 'min:14', 'max:15'],
            'dependent_birth' => 'required'
        ]);

        if (DependentRepository::insert($httpRequest, $citizen->id)) {
            return $this->hasBeenInserted();
        }

        return $this->couldntInsert();
    }

    /**
     *  Loads edit page
     *
     *  @param int $id
     *  @param int $dependentId
     *
     *  @return mixed
     */
    public function edit(int $id, int $dependentId)
    {
        $this->firewall('citizen.update');

        $citizen = CitizenRepository::find($id);
        $dependent = DependentRepository::find($dependentId);

        if (!$citizen || !$dependentId) {
            return $this->couldntFind();
        }

        $phoneRequired = false;
        $phone = $dependent->phone;
        $phone2 = false;
        $phoneType = PhoneTypeRepository::all();

        return view(
            'logged.citizen.dependent.form',
            compact(
                'citizen',
                'dependent',
                'phone',
                'phone2',
                'phoneRequired',
                'phoneType'
            )
        );
    }

    /**
     *  Updates citizen
     *
     *  @param HttpRequest $httpRequest
     *  @param int $id
     *
     *  @return mixed
     */
    public function update(HttpRequest $httpRequest, int $citizenId, int $id)
    {
        $this->firewall('citizen.update');

        $citizen = CitizenRepository::find($citizenId);
        $dependent = DependentRepository::find($id);

        if (!$citizen || !$dependent) {
            return $this->couldntFind();
        }

        $validated = $httpRequest->validate([
            'dependent_name' => ['required', 'max:100'],
            'phone_number' => ['nullable', 'min:14', 'max:15'],
            'dependent_birth' => 'required'
        ]);

        if (DependentRepository::update($dependent, $httpRequest)) {
            return $this->hasBeenUpdated();
        }

        return $this->couldntUpdate();
    }
}
