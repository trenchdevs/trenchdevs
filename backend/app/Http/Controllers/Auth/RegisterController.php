<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Modules\Emails\Models\EmailLog;
use App\Providers\RouteServiceProvider;
use App\Modules\Users\Models\User;
use ErrorException;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    const PASSWORD_VALIDATION_RULE = ['required', 'string', 'min:8', 'confirmed'];

    /**
     * Where to redirect users after registration.
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
        parent::__construct();
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string',
                'email',
                'max:255',
                Rule::unique('users')->where(function (Builder $query) use ($data) {
                    return $query->where('email', $data['email'] ?? '')
                        ->where('site_id', $this->site->id);
                })
            ],
            'password' => self::PASSWORD_VALIDATION_RULE,
            'tnc' => 'required',
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {

        // basic validations
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     * @throws
     */
    protected function create(array $data)
    {

        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'site_id' => $this->site->id,
            'is_active' => 1,
            'password' => Hash::make($data['password']),
            'role' => User::ROLE_CONTRIBUTOR,
        ]);
    }

    protected function registered(Request $request, $user)
    {
        $this->notifyOnNewUserRegistered($user);

//        return view('auth.verify');
    }

    /**
     * notify admin on new users for now
     * @param $user
     */
    private function notifyOnNewUserRegistered($user): void
    {
        try {

            if (app()->environment('production')) {
                throw new Exception("Not needed on locals");
            }

            $email = $user->email ?? '';
            $id = $user->id ?? '';

            $notifier = EmailLog::createGenericMail(
                'support@trenchdevs.org',
                'New user registered',
                "A new user registered on the system. (email is: {$email}, id = {$id})"
            ); // send immediately

            $notifier->send();

        } catch (Throwable $throwable) {
            // suppress
        }
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('web');
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
