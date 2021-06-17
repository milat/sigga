<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Repositories\PhoneTypeRepository;
use App\Repositories\AddressTypeRepository;
use Illuminate\Http\Request as HttpRequest;
use App\Repositories\OrganizationRepository;

class OrganizationController extends Controller
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
        $this->firewall('organization');
        return view('logged.organization.index');
    }

    /**
     *  Searches for organization by query
     *
     *  @param string $query
     *
     *  @return View|Factory
     */
    public function search(string $query = '')
    {
        $this->firewall('organization');
        $organizations = OrganizationRepository::search($query);
        return view('logged.organization.search', compact('organizations'));
    }

    /**
     *  Loads insert page
     *
     *  @return View|Factory
     */
    public function create()
    {
        $this->firewall('organization.insert');

        $organization = false;
        $address = false;
        $addressType = AddressTypeRepository::all();
        $isAddressRequired = false;
        $phone = false;
        $phone2 = false;
        $phoneType = PhoneTypeRepository::all();
        $branches = OrganizationRepository::getAllBranches();

        return view(
            'logged.organization.form',
            compact(
                'organization',
                'address',
                'addressType',
                'isAddressRequired',
                'phone',
                'phone2',
                'phoneType',
                'branches'
            )
        );
    }

    /**
     *  Persists organization
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return Redirector|RedirectResponse
     */
    public function insert(HttpRequest $httpRequest)
    {
        $this->firewall('organization.insert');

        $validated = $httpRequest->validate([
            'organization_name' => ['required', 'max:100'],
            'organization_contact' => ['required', 'max:100'],
            'organization_email' => ['nullable', 'email', 'max:100'],
            'organization_identity_document' => ['nullable', Rule::unique('organizations', 'identity_document'), 'cnpj', 'formato_cnpj', 'max:30'],
            'phone_phone_type_id' => 'required',
            'phone_number' => ['required', 'min:14', 'max:15'],
            'phone_number_2' => ['nullable', 'min:14', 'max:15'],
            'address_code' => ['nullable', 'max:15'],
            'address_name' => ['nullable', 'max:255'],
            'address_number' => ['nullable', 'max:10'],
            'address_extra' => ['nullable', 'max:255'],
            'address_neighborhood' => ['nullable', 'max:255'],
            'address_city' => ['nullable', 'max:100'],
            'address_state' => ['nullable', 'max:30']
        ]);

        if (OrganizationRepository::insert($httpRequest)) {
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
        $this->firewall('organization.update');

        $organization = OrganizationRepository::find($id);

        if (!$organization) {
            return $this->couldntFind();
        }

        $address = $organization->address;
        $addressType = AddressTypeRepository::all();
        $isAddressRequired = false;
        $phone = $organization->phone;
        $phone2 = $organization->phone2;
        $phoneType = PhoneTypeRepository::all();
        $branches = OrganizationRepository::getAllBranches();

        return view(
            'logged.organization.form',
            compact(
                'organization',
                'address',
                'addressType',
                'isAddressRequired',
                'phone',
                'phone2',
                'phoneType',
                'branches'
            )
        );
    }

    /**
     *  Updates organization
     *
     *  @param HttpRequest $httpRequest
     *  @param int $id
     *
     *  @return mixed
     */
    public function update(HttpRequest $httpRequest, int $id)
    {
        $this->firewall('organization.update');

        $organization = OrganizationRepository::find($id);

        if (!$organization) {
            return $this->couldntFind();
        }

        $validated = $httpRequest->validate([
            'organization_trade' => ['required', 'max:30'],
            'organization_contact' => ['required', 'max:100'],
            'organization_email' => ['nullable', 'email', 'max:100'],
            'organization_identity_document' => ['nullable', Rule::unique('organizations', 'identity_document')->ignore($organization->id), 'cnpj', 'formato_cnpj', 'max:30'],
            'phone_phone_type_id' => 'required',
            'phone_number' => ['required', 'min:14', 'max:15'],
            'phone_number_2' => ['nullable', 'min:14', 'max:15'],
            'address_code' => ['nullable', 'max:15'],
            'address_name' => ['nullable', 'max:255'],
            'address_number' => ['nullable', 'max:10'],
            'address_extra' => ['nullable', 'max:255'],
            'address_neighborhood' => ['nullable', 'max:255'],
            'address_city' => ['nullable', 'max:100'],
            'address_state' => ['nullable', 'max:30']
        ]);

        if (OrganizationRepository::update($organization, $httpRequest)) {
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
        $organization = OrganizationRepository::find($id);

        if (!$organization) {
            return;
        }

        $address = $organization->address;
        $phone = $organization->phone;
        $phone2 = $organization->phone2;

        return view(
            'logged.organization.view',
            compact(
                'organization',
                'address',
                'phone',
                'phone2'
            )
        );
    }
}
