<?php

namespace App\Repositories;

use App\Models\Citizen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request as HttpRequest;

class CitizenRepository extends Repository
{
    /**
     *  Finds Citizen by id
     *
     *  @param int $id
     *
     *  @return Citizen|bool
     */
    public static function find(int $id)
    {
        return self::findIn(Citizen::class, $id);
    }

    /**
     *  Searches for citizen by query
     *
     *  @param string $query
     *
     *  @return array
     */
    public static function search(string $query)
    {
        return Citizen::search($query);
    }

    /**
     *  Persists citizen
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return bool
     */
    public static function insert(HttpRequest $httpRequest)
    {
        $citizen = new Citizen;
        $citizen->office_id = Auth::user()->office_id;
        $citizen->created_by_user_id = Auth::user()->id;

        self::set($citizen, $httpRequest);

        if ($citizen->save()) {
            AddressRepository::save($httpRequest, $citizen);
            PhoneRepository::save($httpRequest, $citizen);
            return true;
        }

        return false;
    }

    /**
     *  Updates citizen
     *
     *  @param Citizen $citizen
     *  @param HttpRequest $httpRequest
     *
     *  @return bool
     */
    public static function update(Citizen $citizen, HttpRequest $httpRequest)
    {
        self::set($citizen, $httpRequest);

        if ($citizen->save()) {
            AddressRepository::save($httpRequest, $citizen);
            PhoneRepository::save($httpRequest, $citizen);
            return true;
        }

        return false;
    }

    /**
     *  Returns office's active citizens
     *
     *  @return array
     */
    public static function getActives()
    {
        return Citizen::getActives();
    }

    /**
     *  Sets citizen model with HttpRequest
     *
     *  @param Citizen $citizen
     *  @param HttpRequest $httpRequest
     *
     *  @return void
     */
    private static function set(Citizen &$citizen, HttpRequest $httpRequest)
    {
        $citizen->updated_by_user_id = Auth::user()->id;
        $citizen->name = $httpRequest->citizen_name;
        $citizen->email = $httpRequest->citizen_email;
        $citizen->identity_document = $httpRequest->citizen_identity_document;
        $citizen->birth = $httpRequest->citizen_birth;
        $citizen->note = $httpRequest->citizen_note;
        $citizen->is_active = $httpRequest->citizen_is_active;
    }
}
