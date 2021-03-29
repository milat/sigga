<?php

namespace App\Repositories;

use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;

class SuperuserRepository
{
    /**
     *  Logs superuser in
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return bool
     */
    public static function login(HttpRequest $httpRequest)
    {
        $credentials = $httpRequest->only('email', 'password');
        $remember = (bool) (isset($httpRequest->remember) && $httpRequest->remember == 'on');

        if (Auth::guard('admin')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'is_active' => 1
        ], $remember)) {
            $httpRequest->session()->regenerate();
            return true;

        }

        return false;
    }

    /**
     *  Logs superuser out
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return bool
     */
    public static function logout(HttpRequest $httpRequest)
    {
        try {
            Auth::guard('admin')->logout();
            $httpRequest->session()->invalidate();
            $httpRequest->session()->regenerateToken();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
