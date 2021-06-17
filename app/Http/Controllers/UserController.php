<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Utils\Language;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Repositories\PhoneTypeRepository;
use Illuminate\Http\Request as HttpRequest;

class UserController extends Controller
{
    /**
     *  Create a new controller instance.
     *
     *  @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('login', 'logout');
    }

    /**
     *  Loads user index
     *
     *  @return View|Factory
     */
    public function index()
    {
        $this->firewall('user');
        return view('logged.user.index');
    }

    /**
     *  Searches for user by query
     *
     *  @param string $query
     *
     *  @return View|Factory
     */
    public function search(string $query = '')
    {
        $this->firewall('user');
        $users = UserRepository::search($query);
        return view('logged.user.search', compact('users'));
    }

    /**
     *  Loads insert page
     *
     *  @return View|Factory
     */
    public function create()
    {
        $this->firewall('user.insert');
        $user = false;
        $roles = Role::actives();
        $phoneRequired = false;
        $phone = false;
        $phone2 = false;
        $phoneType = PhoneTypeRepository::all();

        return view(
            'logged.user.form',
            compact(
                'user',
                'roles',
                'phoneRequired',
                'phone',
                'phone2',
                'phoneType'
            )
        );
    }

    /**
     *  Persist user
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return Redirector|RedirectResponse
     */
    public function insert(HttpRequest $httpRequest)
    {
        $this->firewall('user.insert');

        $validated = $httpRequest->validate([
            'user_name' => ['required', 'max:100'],
            'user_email' => ['required', 'email', Rule::unique('users', 'email'), 'max:100'],
            'user_role_id' => 'required',
            'user_identity_document' => ['nullable', 'cpf', 'formato_cpf', 'max:20']
        ]);

        if (UserRepository::insert($httpRequest)) {
            return $this->hasBeenInserted();
        }

        return $this->couldntInsert();
    }

    /**
     *  Loads edit page
     *
     *  @param int $id
     *
     *  @return RedirectResponse|View|Factory
     */
    public function edit(int $id)
    {
        $this->firewall('user.update');

        $user = UserRepository::find($id);

        if (!$user) {
            return $this->couldntFind();
        }

        $roles = Role::actives();
        $phoneRequired = false;
        $phone = $user->phone;
        $phone2 = false;
        $phoneType = PhoneTypeRepository::all();

        return view(
            'logged.user.form',
            compact(
                'user',
                'roles',
                'phoneRequired',
                'phone',
                'phone2',
                'phoneType'
            )
        );
    }

    /**
     *  Updates user
     *
     *  @param HttpRequest $httpRequest
     *  @param int $id
     *
     *  @return Redirector|RedirectResponse
     */
    public function update(HttpRequest $httpRequest, int $id)
    {
        $this->firewall('user.update');

        $user = UserRepository::find($id);

        if (!$user) {
            return $this->couldntFind();
        }

        $validated = $httpRequest->validate([
            'user_name' => ['required', 'max:100'],
            'user_email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id), 'max:100'],
            'user_role_id' => 'required',
            'user_identity_document' => ['nullable', 'cpf', 'formato_cpf', 'max:20']
        ]);

        if (UserRepository::update($user, $httpRequest)) {
            return $this->hasBeenUpdated();
        }

        return $this->couldntUpdate();
    }

    /**
     *  Loads view page
     *
     *  @param int $id
     *
     *  @return RedirectResponse|View|Factory
     */
    public function view(int $id)
    {
        $user = UserRepository::find($id);

        if (!$user) {
            return;
        }

        return view('logged.user.view', compact('user'));
    }

    /**
     *  Loads password page
     *
     *  @return View|Factory
     */
    public function password()
    {
        return view('logged.user.password');
    }

    /**
     *  Updates user password
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return Redirector|RedirectResponse
     */
    public function passwordAction(HttpRequest $httpRequest)
    {
        $validated = $httpRequest->validate([
            'password_current' => ['required', 'max:100'],
            'password_new' => ['required', 'min:6', 'max:100', 'same:password_confirm'],
            'password_confirm' => ['required'],
        ]);

        if (!UserRepository::auth(Auth::user()->email, $httpRequest->password_current)) {
            return redirect()->route('user.password')
                            ->with('error', Language::get('password_invalid'));
        }

        if (UserRepository::updatePassword($httpRequest)) {
            return $this->hasBeenUpdated();
        }

        return $this->couldntUpdate();
    }

    /**
     *  Logs in
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return Redirector|RedirectResponse
     */
    public function login(HttpRequest $httpRequest)
    {
        if (UserRepository::login($httpRequest)) {
            return redirect()->intended('/home');
        }

        return back()->withErrors([
            'email' => Language::get('login_error'),
        ]);
    }

    /**
     *  Logs out
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return Redirector|RedirectResponse
     */
    public function logout(HttpRequest $httpRequest)
    {
        if (UserRepository::logout($httpRequest)) {
            return redirect('/');
        }

        return redirect()->back()->withErrors('error', Language::get('logout_error'));
    }
}
