<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Repositories\RequestCategoryRepository;
use App\Repositories\RequestStatusRepository;
use Illuminate\Contracts\View\Factory;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *  Loads logged index
     *
     *  @return View|Factory
     */
    public function index()
    {
        $category = RequestCategoryRepository::getDashboardData();
        $status = RequestStatusRepository::getDashboardStatus();

        $data = $category + $status;
        return view('logged.home.index', compact('data'));
    }
}
