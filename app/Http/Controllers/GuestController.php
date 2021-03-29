<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;

class GuestController extends Controller
{
    /**
     *  Create a new controller instance.
     *
     *  @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     *  Loads login view
     *
     *  @return View|Factory
     */
    public function login()
    {
        return view('auth.login');
    }
}
