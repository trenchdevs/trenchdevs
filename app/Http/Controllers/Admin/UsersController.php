<?php

namespace App\Http\Controllers\Admin;

use App\Account;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Throwable;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $users = User::whereIn('role', $user->getAllowedRolesToManage())
            ->where('id', '!=', $user->id)
            ->paginate();

        return view('admin.users.index', ['users' => $users]);
    }

    protected function validator($create = true)
    {
        /** @var User $user */
        $user = Auth::user();

        $defaultValidator = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'is_active' => ['required', Rule::in('1', '0')],
            'role' => ['required', Rule::in($user->getAllowedRolesToManage())],
        ];

        if ($create) {
            $defaultValidator['email'] = ['required', 'string', 'email', 'max:255', 'unique:users'];
            $defaultValidator['password'] = ['required', 'string', 'min:8'];
        }

        return $defaultValidator;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        return view('admin.users.upsert', [
            'user' => new User,
            'action' => route('users.upsert'),
            'editMode' => false,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|Response|View
     */
    public function show($id)
    {
        return view('admin.users.show', ['user' => User::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|Response|View
     */
    public function edit($id)
    {
        return view('admin.users.upsert', [
            'user' => User::findOrFail($id),
            'action' => route('users.upsert'),
            'editMode' => true,
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws ValidationException
     * @throws Throwable
     */
    public function upsert(Request $request)
    {
        $data = $request->all();

        /** @var User $user */
        if ($request->id) {

            $this->validate($request, $this->validator(false));

            unset($data['password'], $data['email']);
            /**
             * Update
             */
            $user = User::findOrFail($request->id);
            $user->fill($data);
            $user->saveOrFail();

            Session::flash('message', "Successfully updated user " . $user->name());

        } else {

            $this->validate($request, $this->validator(true));

            /**
             * Create
             */
            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'account_id' => Account::getTrenchDevsAccount()->id, // todo: can modify later
                'is_active' => $data['is_active'],
                'email_verified_at' => date('Y-m-d H:i:s'),
                'role' => $data['role'],
                'password' => $data['password'],
            ]);

            Session::flash('message', "Successfully created new user " . $user->name());
        }

        return redirect(route('users.index'));


    }

    public function passwordReset(Request $request)
    {

        $id = $request->id ?? null;

        if (empty($id)) {
            abort(404);
        }

        /** @var User $user */
        $user = User::findOrFail($id);

        $token = Password::getRepository()->create($user);
        $user->sendPasswordResetNotification($token);

        Session::flash('message', "Successfully sent password reset email to user " . $user->name());

        return redirect(route('users.index'));
    }
}
