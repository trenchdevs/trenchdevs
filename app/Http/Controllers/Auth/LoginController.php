<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\UserLogin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    protected function guard()
    {
        return Auth::guard('web');
    }

    /**
     * The user has been authenticated.
     *
     * @param Request $request
     * @param User $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {

        if (!$user->isActive() || !$user->hasVerifiedEmail()) {
            return view('auth.inactive-user');
        }

        // else all good, login user and redirect to homepage
        Auth::login($user);

        $userLogin = new UserLogin;
        $userLogin->fill([
            'user_id' => $user->id,
            'type' => UserLogin::DB_TYPE_LOGIN,
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'referer' => $request->header('referer'),
            'misc_json' => json_encode([
                'email' => $request->email,
            ]),
        ]);
        $userLogin->save();

        return redirect('/home');
    }

    /**
     * Increment the login attempts for the user.
     *
     * @param Request $request
     * @return void
     */
    protected function incrementLoginAttempts(Request $request)
    {

        $userLogin = new UserLogin;
        $userLogin->fill([
            'user_id' => null,
            'type' => UserLogin::DB_TYPE_LOGIN_ATTEMPT,
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'referer' => $request->header('referer'),
            'misc_json' => json_encode([
                'email' => $request->email,
            ]),
        ]);
        $userLogin->save();

        $this->limiter()->hit(
            $this->throttleKey($request), $this->decayMinutes() * 60
        );
    }
}
