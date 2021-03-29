<?php

namespace App\Http\Controllers;

use App\Utils\Language;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use App\Repositories\RoleRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request as HttpRequest;

class RoleController extends Controller
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
        $this->firewall('role');
        return view('logged.role.index');
    }

    /**
     *  Searches for role by query
     *
     *  @param string $query
     *
     *  @return View|Factory
     */
    public function search(string $query = '')
    {
        $this->firewall('role');
        $roles = RoleRepository::search($query);
        return view('logged.role.search', compact('roles'));
    }

    /**
     *  Loads insert page
     *
     *  @return View|Factory
     */
    public function create()
    {
        $this->firewall('role.insert');
        $role = false;
        return view('logged.role.form', compact('role'));
    }

    /**
     *  Persists role
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return Redirector|RedirectResponse
     */
    public function insert(HttpRequest $httpRequest)
    {
        $this->firewall('role.insert');

        $validated = $httpRequest->validate([
            'role_name' => ['required', 'max:15'],
            'role_is_active' => 'required'
        ]);

        $role = RoleRepository::insert($httpRequest);

        if ($role) {
            return redirect()->route('role.permission', $role->id)
                    ->with('success', Language::get('insert_success'));
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
        $this->firewall('role.update');

        $role = RoleRepository::find($id);

        if (!$role) {
            return $this->couldntFind();
        }

        return view('logged.role.form', compact('role'));
    }

    /**
     *  Updates role
     *
     *  @param HttpRequest $httpRequest
     *  @param int $id
     *
     *  @return mixed
     */
    public function update(HttpRequest $httpRequest, int $id)
    {
        $this->firewall('role.update');

        $role = RoleRepository::find($id);

        if (!$role) {
            return $this->couldntFind();
        }

        $validated = $httpRequest->validate([
            'role_name' => ['required', 'max:15'],
            'role_is_active' => 'required'
        ]);

        if (RoleRepository::update($role, $httpRequest)) {
            return $this->hasBeenUpdated();
        }

        return $this->couldntUpdate();
    }

    /**
     *  Loads permissions page
     *
     *  @param int $id
     *
     *  @return View|Factory
     */
    public function permission(int $id)
    {
        $this->firewall('role.permission');

        $role = RoleRepository::find($id);

        if (!$role) {
            return $this->couldntFind();
        }

        return view('logged.role.permission', compact('role'));
    }

    /**
     *  Updates role permission
     *
     *  @param HttpRequest $httpRequest
     *  @param int $id
     *
     *  @return JsonResponse
     */
    public function access(HttpRequest $httpRequest, int $id)
    {
        $this->firewall('role.permission');

        $role = RoleRepository::find($id);

        if ($role && $httpRequest->has('role_id') && $httpRequest->has('permission_id') && $httpRequest->has('is_allowed')) {
            $success = (bool)RoleRepository::access($role, $httpRequest);
        } else {
            $success = false;
        }

        return response()->json(['success' => $success]);
    }
}
