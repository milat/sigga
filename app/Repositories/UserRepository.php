<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository extends Repository
{
    /**
     *  Find user by id
     *
     *  @param int $id
     *
     *  @return User|bool
     */
    public static function find(int $id)
    {
        return self::findIn(User::class, $id);
    }

    /**
     *  Searches for user by query
     *
     *  @param string $query
     *
     *  @return array
     */
    public static function search(string $query)
    {
        return User::search($query);
    }

    /**
     *  Persist user
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return bool
     */
    public static function insert(HttpRequest $httpRequest)
    {
        $user = new User;
        $user->office_id = Auth::user()->office_id;
        self::set($user, $httpRequest);
        $user->password = Hash::make(config('system.generate_password'));

        if ($user->save()) {
            PhoneRepository::save($httpRequest, $user);
            return true;
        }

        return false;
    }

    /**
     *  Updates user
     *
     *  @param User $user
     *  @param HttpRequest $httpRequest
     *
     *  @return bool
     */
    public static function update(User $user, HttpRequest $httpRequest)
    {
        self::set($user, $httpRequest);

        if ($user->save()) {
            PhoneRepository::save($httpRequest, $user);
            return true;
        }

        return false;
    }

    /**
     *  Updates user password
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return bool
     */
    public static function updatePassword(HttpRequest $httpRequest)
    {
        if ($httpRequest->password_new !== $httpRequest->password_confirm) {
            return false;
        }

        $user = self::find(Auth::user()->id);
        $user->password = Hash::make($httpRequest->password_new);

        return $user->save();
    }

    /**
     *  Authenticates user
     *
     *  @param string $email
     *  @param string $password
     *  @param bool $isActive
     *  @param bool $remember
     *
     *  @return bool
     */
    public static function auth(string $email, string $password, bool $isActive = null, bool $remember = false)
    {
        $params = [
            'email' => $email,
            'password' => $password
        ];

        if (!is_null($isActive)) {
            $params['is_active'] = (int) $isActive;
        }

        return (bool) Auth::attempt($params, $remember);
    }

    /**
     *  Logs in
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return bool
     */
    public static function login(HttpRequest $httpRequest)
    {
        $credentials = $httpRequest->only('email', 'password');
        $remember = (bool) (isset($httpRequest->remember) && $httpRequest->remember == 'on');

        if (self::auth($credentials['email'], $credentials['password'], 1, $remember)) {
            $httpRequest->session()->regenerate();
            return true;
        }

        return false;
    }

    /**
     *  Logs out
     *
     *  @param HttpRequest $httpRequest
     *
     *  @return bool
     */
    public static function logout(HttpRequest $httpRequest)
    {
        try {
            Auth::logout();
            $httpRequest->session()->invalidate();
            $httpRequest->session()->regenerateToken();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     *  Return office's active users
     *
     *  @return array
     */
    public static function getActives()
    {
        return User::getActives();
    }

    /**
     *  Sets user model with HttpRequest
     *
     *  @param User $user
     *  @param HttpRequest $httpRequest
     *
     *  @return void
     */
    private static function set(User $user, HttpRequest $httpRequest)
    {
        $user->name = $httpRequest->user_name;
        $user->email = $httpRequest->user_email;
        $user->identity_document = $httpRequest->user_identity_document;
        $user->role_id = $httpRequest->user_role_id;
        $user->is_active = $httpRequest->user_is_active;
    }
}
