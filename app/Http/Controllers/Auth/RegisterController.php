<?php

namespace App\Http\Controllers\Auth;

use App\Account;
use App\Http\Controllers\Controller;
use App\Models\EmailQueue;
use App\Providers\RouteServiceProvider;
use App\User;
use ErrorException;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => self::PASSWORD_VALIDATION_RULE,
            'tnc' => 'required',
        ]);
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

        $account = Account::getTrenchDevsAccount();

        if (!$account) {
            throw new ErrorException("TrenchDevs Account not found");
        }

        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'account_id' => $account->id,
            'is_active' => 1,
            'password' => Hash::make($data['password']),
            'role' => User::ROLE_CONTRIBUTOR,
        ]);
    } 

    protected function registered(Request $request, $user)
    {
        $this->notifyOnNewUserRegistered($user);

        return view('auth.verify');
    }

    /**
     * notify admin on new users for now
     * @param $user
     */
    private function notifyOnNewUserRegistered($user): void
    {
        try {

            $email = $user->email ?? '';
            $id = $user->id ?? '';

            $notifier = EmailQueue::createGenericMail(
                'support@trenchdevs.org',
                'New user registered',
                "A new user registered on the system. (email is: {$email}, id = {$id})"
            ); // send immediately

            $notifier->send();

        } catch (Throwable $throwable) {
            // suppress
        }
    }
}
