<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Repositories\RequestCategoryRepository;

class RequestCategoryController extends Controller
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
        $this->firewall('category');
        return view('logged.request.category.index');
    }

    /**
     *  Searches for category by query
     *
     *  @param string $query
     *
     *  @return View|Factory
     */
    public function search(string $query = '')
    {
        $this->firewall('category');
        $categories = RequestCategoryRepository::search($query);
        return view('logged.request.category.search', compact('categories'));
    }

    /**
     *  Loads insert page
     *
     *  @return View|Factory
     */
    public function create()
    {
        $this->firewall('category.insert');
        $category = false;
        return view('logged.request.category.form', compact('category'));
    }

    /**
     *  Persists category
     *
     *  @param Request $request
     *
     *  @return Redirector|RedirectResponse
     */
    public function insert(Request $request)
    {
        $this->firewall('category.insert');

        $validated = $request->validate([
            'category_name' => ['required', 'max:20'],
            'category_is_active' => 'required'
        ]);

        if (RequestCategoryRepository::insert($request)) {
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
        $this->firewall('category.update');

        $category = RequestCategoryRepository::find($id);

        if (!$category) {
            return $this->couldntFind();
        }

        return view('logged.request.category.form', compact('category'));
    }

    /**
     *  Updates request category
     *
     *  @param Request $request
     *  @param int $id
     *
     *  @return mixed
     */
    public function update(Request $request, int $id)
    {
        $this->firewall('category.update');

        $category = RequestCategoryRepository::find($id);

        if (!$category) {
            return $this->couldntFind();
        }

        $validated = $request->validate([
            'category_name' => ['required', 'max:20'],
            'category_is_active' => 'required'
        ]);

        if (RequestCategoryRepository::update($category, $request)) {
            return $this->hasBeenUpdated();
        }

        return $this->couldntUpdate();
    }
}
