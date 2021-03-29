<?php

namespace App\Http\Controllers;

use App\Utils\Language;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     *  Bloqueia usuários que não possuem acesso
     *
     *  @param string $permission
     *
     *  @return void
     */
    protected function firewall(string $permission)
    {
        if (Auth::user()->cant($permission)) {
            abort(403);
        }
    }

    /**
     *  Redirects with error message
     *
     *  @return Redirector|RedirectResponse
     */
    protected function couldntFind()
    {
        return redirect()->back()
                ->withErrors([
                    'not_found' => Language::get('not_found'),
                ]);
    }

    /**
     *  Redirects with success message
     *
     *  @return Redirector|RedirectResponse
     */
    protected function hasBeenInserted()
    {
        return redirect()
                ->back()
                ->with(
                    'success', Language::get('insert_success')
                );
    }

    /**
     *  Redirects with error message
     *
     *  @return Redirector|RedirectResponse
     */
    protected function couldntInsert()
    {
        return redirect()
                ->back()
                ->with(
                    'error', Language::get('insert_error')
                );
    }

    /**
     *  Redirects with success message
     *
     *  @return Redirector|RedirectResponse
     */
    protected function hasBeenUpdated()
    {
        return redirect()
                ->back()
                ->with(
                    'success', Language::get('update_success')
                );
    }

    /**
     *  Redirects with error message
     *
     *  @return Redirector|RedirectResponse
     */
    protected function couldntUpdate()
    {
        return redirect()
                ->back()
                ->with(
                    'error', Language::get('update_error')
                );
    }
}
