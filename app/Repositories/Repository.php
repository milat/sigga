<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    /**
     *  Generic search by id & validation
     *
     *  @param string $modelName
     *  @param int $id
     *  @param bool $validation
     */
    protected static function findIn(string $modelName, int $id, bool $validation = true)
    {
        $data = $modelName::find($id);

        if (!$data) {
            return false;
        }

        if ($validation) {
            self::validate($data);
        }

        return $data;
    }

    /**
     *  Checks if data belongs to office
     *
     *  @param Model $model
     */
    protected static function validate(Model $model)
    {
        if ($model->office_id != Auth::user()->office_id) {
            abort(403);
        }
    }
}
