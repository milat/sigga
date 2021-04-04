<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Repositories\CitizenRepository;
use App\Repositories\PhoneTypeRepository;
use App\Repositories\AddressTypeRepository;
use Illuminate\Http\Request as HttpRequest;

class CitizenController extends Controller
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
     *  @return View|Factory
     */
    public function index()
    {
        $this->firewall('citizen');
        return view('logged.citizen.index');
    }

    /**
     *  Searches for citizen by query
     *
     *  @param string $query
     *
     *  @return View|Factory
     */
    public function search(string $query = '')
    {
        $this->firewall('citizen');
        $citizens = CitizenRepository::search($query);
        return view('logged.citizen.search', compact('citizens'));
    }

    /**
     *  Loads insert page
     *
     *  @return View|Factory
     */
    public function create()
    {
        $this->firewall('citizen.insert');

        $citizen = false;
        $address = false;
        $addressType = AddressTypeRepository::all();
        $isAddressRequired = true;
        $phone = false;
        $phone2 = false;
        $phoneType = PhoneTypeRepository::all();

        return view(
            'logged.citizen.form',
            compact(
                'citizen',
                'address',
                'addressType',
                'isAddressRequired',
                'phone',
                'phone2',
                'phoneType'
            )
        );
    }

    /**
     *  Persists citizen
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return Redirector|RedirectResponse
     */
    public function insert(HttpRequest $httpRequest)
    {
        $this->firewall('citizen.insert');

        $validated = $httpRequest->validate([
            'citizen_name' => ['required', 'max:100'],
            'citizen_email' => ['nullable', 'email', 'max:100'],
            'citizen_identity_document' => ['required', Rule::unique('citizens', 'identity_document'), 'cpf', 'formato_cpf', 'max:20'],
            'phone_phone_type_id' => 'required',
            'phone_number' => ['required', 'min:14', 'max:15'],
            'phone_number2' => ['nullable', 'min:14', 'max:15'],
            'address_postal_code' => ['nullable', 'max:15'],
            'address_address' => ['required', 'max:255'],
            'address_number' => ['required', 'max:10'],
            'address_extra' => ['nullable', 'max:255'],
            'address_address_type_id' => 'required',
            'address_neighborhood' => ['required', 'max:255'],
            'address_city' => ['required', 'max:100'],
            'address_state' => ['required', 'max:30']
        ]);

        if (CitizenRepository::insert($httpRequest)) {
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
        $this->firewall('citizen.update');

        $citizen = CitizenRepository::find($id);

        if (!$citizen) {
            return $this->couldntFind();
        }

        $address = $citizen->address;
        $addressType = AddressTypeRepository::all();
        $isAddressRequired = true;
        $phone = $citizen->phone;
        $phone2 = $citizen->phone2;
        $phoneType = PhoneTypeRepository::all();

        return view(
            'logged.citizen.form',
            compact(
                'citizen',
                'address',
                'addressType',
                'isAddressRequired',
                'phone',
                'phone2',
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
    public function update(HttpRequest $httpRequest, int $id)
    {
        $this->firewall('citizen.update');

        $citizen = CitizenRepository::find($id);

        if (!$citizen) {
            return $this->couldntFind();
        }

        $validated = $httpRequest->validate([
            'citizen_name' => ['required', 'max:100'],
            'citizen_email' => ['nullable', 'email', 'max:100'],
            'citizen_identity_document' => ['required', Rule::unique('citizens', 'identity_document')->ignore($citizen->id), 'cpf', 'formato_cpf', 'max:20'],
            'phone_phone_type_id' => 'required',
            'phone_number' => ['required', 'min:14', 'max:15'],
            'phone_number2' => ['nullable', 'min:14', 'max:15'],
            'address_postal_code' => ['nullable', 'max:15'],
            'address_address' => ['required', 'max:255'],
            'address_number' => ['required', 'max:10'],
            'address_extra' => ['nullable', 'max:255'],
            'address_address_type_id' => 'required',
            'address_neighborhood' => ['required', 'max:255'],
            'address_city' => ['required', 'max:100'],
            'address_state' => ['required', 'max:30']
        ]);

        if (CitizenRepository::update($citizen, $httpRequest)) {
            return $this->hasBeenUpdated();
        }

        return $this->couldntUpdate();
    }

    /**
     *  Loads view page
     *
     *  @param HttpRequest $httpRequest
     *  @param int $id
     *
     *  @return mixed
     */
    public function view(HttpRequest $httpRequest, int $id)
    {
        $citizen = CitizenRepository::find($id);

        if (!$citizen) {
            return;
        }

        $address = $citizen->address;
        $phone = $citizen->phone;
        $phone2 = $citizen->phone2;

        return view(
            'logged.citizen.view',
            compact(
                'citizen',
                'address',
                'phone',
                'phone2'
            )
        );
    }
}