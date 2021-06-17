<?php

namespace App\Repositories;

use App\Models\Dependent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request as HttpRequest;

class DependentRepository extends Repository
{
    /**
     *  Finds Dependent by id
     *
     *  @param int $id
     *
     *  @return Dependent|bool
     */
    public static function find(int $id)
    {
        return self::findIn(Dependent::class, $id, false);
    }

    /**
     *  Persists dependent
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return bool
     */
    public static function insert(HttpRequest $httpRequest, int $citizenId)
    {
        $dependent = new Dependent;
        $dependent->citizen_id = $citizenId;
        $dependent->created_by_user_id = Auth::user()->id;

        self::set($dependent, $httpRequest);

        if ($dependent->save()) {
            PhoneRepository::save($httpRequest, $dependent);
            return true;
        }

        return false;
    }

    /**
     *  Updates dependent
     *
     *  @param Dependent $dependent
     *  @param HttpRequest $httpRequest
     *
     *  @return bool
     */
    public static function update(Dependent $dependent, HttpRequest $httpRequest)
    {
        self::set($dependent, $httpRequest);

        if ($dependent->save()) {
            PhoneRepository::save($httpRequest, $dependent);
            return true;
        }

        return false;
    }

    /**
     *  Sets dependent model with HttpRequest
     *
     *  @param Dependent $dependent
     *  @param HttpRequest $httpRequest
     *
     *  @return void
     */
    private static function set(Dependent &$dependent, HttpRequest $httpRequest)
    {
        $dependent->updated_by_user_id = Auth::user()->id;
        $dependent->name = $httpRequest->dependent_name;
        $dependent->identity_document = $httpRequest->dependent_identity_document;
        $dependent->birth = $httpRequest->dependent_birth;
        $dependent->note = $httpRequest->dependent_note;
        $dependent->is_active = $httpRequest->dependent_is_active;
    }
}