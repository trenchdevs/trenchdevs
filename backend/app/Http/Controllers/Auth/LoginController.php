<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Domains\Sites\Models\Site;
use App\Providers\RouteServiceProvider;
use App\Domains\Users\Models\User;
use App\Domains\Users\Models\UserLogin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

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

    //use AuthenticatesUsers;
    use RedirectsUsers, ThrottlesLogins;


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
    public function __construct() {
        parent::__construct();
        $this->middleware('guest')->except('logout');
    }


    protected function guard() {
        return Auth::guard('web');
    }

    /**
     * The user has been authenticated.
     *
     * @param Request $request
     * @param User    $user
     *
     * @return mixed
     */
    protected function authenticated(Request $request, $user) {

        if (!$user->isActive()) {
            return view('auth.inactive-user');
        }

        // else all good, login user and redirect to homepage
        Auth::guard('web')->login($user);

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

        return redirect($this->redirectPath());
    }

    /**
     * Increment the login attempts for the user.
     *
     * @param Request $request
     *
     * @return void
     */
    protected function incrementLoginAttempts(Request $request) {

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


    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm() {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param Request $request
     *
     * @return RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request) {
        /**
         * 1. Validate
         */
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);

        /**
         * 2. Check login attempts
         */

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        /**
         * 3. Check credentials
         *      by username/email + password + site_id
         */
        $credentials = $request->only($this->username(), 'password');
        $credentials['site_id'] = $this->site->id;


        if ($this->guard()->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $this->clearLoginAttempts($request);

            /** @var User $user */
            $user = $this->guard()->user();

            if ($response = $this->authenticated($request, $user)) {
                return $response;
            }

            return $request->wantsJson()
                ? new JsonResponse([], 204)
                : redirect()->intended($this->redirectPath());
        }


        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }


    /**
     * Get the failed login response instance.
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request) {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username() {
        return 'email';
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     *
     * @return RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request) {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    /**
     * The user has logged out of the application.
     *
     * @param Request $request
     *
     * @return mixed
     */
    protected function loggedOut(Request $request) {
        //
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath(): string {
        return $this->site->getRedirectPath();
    }


}
