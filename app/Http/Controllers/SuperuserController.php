<?php

namespace App\Http\Controllers;

use App\Utils\Friendly;
use App\Utils\Language;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Repositories\SuperuserRepository;
use Illuminate\Http\Request as HttpRequest;

class SuperuserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin')->except('index', 'login', 'logout');
    }

    /**
     *  Loads index page
     */
    public function index()
    {
        return view('superuser.login');
    }

    /**
     *  Logs superuser in
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return Redirector|RedirectResponse
     */
    public function login(HttpRequest $httpRequest)
    {
        if (SuperuserRepository::login($httpRequest)) {
            return redirect()->intended(Friendly::get('superuser'));
        }

        return back()->withErrors([
            'email' => Language::get('login_error'),
        ]);
    }

    /**
     *  Logs superuser out
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return Redirector|RedirectResponse
     */
    public function logout(HttpRequest $httpRequest)
    {
        SuperuserRepository::logout($httpRequest);
        return redirect('/');
    }
}