<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Modules\Users\Models\User;
use App\Modules\Users\Services\ValidatesUserTrait;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    use ValidatesUserTrait;

    /**
     * Display the registration view.
     *
     * @return Response
     * @throws Exception
     */
    public function create(): Response
    {
        return $this->inertiaRender('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param Request $request
     * @return RedirectResponse
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate($this->validator(true));

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'site_id' => site_id(),
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
