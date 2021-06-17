<?php

namespace App\Repositories;

use App\Models\Organization;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;

class OrganizationRepository extends Repository
{
    /**
     *  Finds organization by id
     *
     *  @param int $id
     *
     *  @return Organization|bool
     */
    public static function find(int $id)
    {
        return self::findIn(Organization::class, $id);
    }

    /**
     *  Searches for organization by query
     *
     *  @param string $query
     *
     *  @return array
     */
    public static function search(string $query)
    {
        return Organization::search($query);
    }

    /**
     *  Persists organization
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return bool
     */
    public static function insert(HttpRequest $httpRequest)
    {
        $organization = new Organization;
        $organization->office_id = Auth::user()->office_id;
        $organization->created_by_user_id = Auth::user()->id;

        self::set($organization, $httpRequest);

        if ($organization->save()) {
            AddressRepository::save($httpRequest, $organization);
            PhoneRepository::save($httpRequest, $organization);
            return true;
        }

        return false;
    }

    /**
     *  Updates organization
     *
     *  @param HttpRequest $httpRequest
     *  @param int $id
     *
     *  @return bool
     */
    public static function update(Organization $organization, HttpRequest $httpRequest)
    {
        self::set($organization, $httpRequest);

        if ($organization->save()) {
            AddressRepository::save($httpRequest, $organization);
            PhoneRepository::save($httpRequest, $organization);
            return true;
        }

        return false;
    }

    /**
     *  Returns office's active organizations
     *
     *  @return array
     */
    public static function getActives()
    {
        return Organization::getActives();
    }

    /**
     *  Returns office's distinct branches
     */
    public static function getAllBranches()
    {
        return Organization::getAllBranches();
    }

    /**
     *  Sets organization model with HttpRequest
     *
     *  @param Organization $organization
     *  @param HttpRequest $httpRequest
     *
     *  @return void
     */
    private static function set(Organization &$organization, HttpRequest $httpRequest)
    {
        $organization->updated_by_user_id = Auth::user()->id;
        $organization->name = $httpRequest->organization_name;
        $organization->branch = $httpRequest->organization_branch;
        $organization->identity_document = $httpRequest->organization_identity_document;
        $organization->email = $httpRequest->organization_email;
        $organization->contact = $httpRequest->organization_contact;
        $organization->note = $httpRequest->organization_note;
        $organization->is_active = $httpRequest->organization_is_active;
    }
}
