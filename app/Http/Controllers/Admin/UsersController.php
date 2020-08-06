<?php

namespace App\Http\Controllers\Admin;

use App\Account;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        $users = User::where('role', '!=', User::ROLE_SUPER_ADMIN)
            ->paginate();

        return view('admin.users.index', ['users' => $users]);
    }

    protected function validator()
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'is_active' => ['required', Rule::in('1', '0')],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', Rule::in(User::VALID_ROLES)],
        ];
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
            'action' => route('users.store'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validator());

        $data = $request->all();

        /** @var User $user */
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'account_id' => Account::getTrenchDevsAccount()->id, // todo: can modify later
            'is_active' => 1,
            'password' => $data['password'],
        ]);


        Session::flash('message', "Successfully created user " . $user->name());

        return redirect(route('users.index'));
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
            'action' => route('users.store')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Application|\Illuminate\Http\RedirectResponse|Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->validator());

        /** @var User $user */
        $user = User::findOrFail($id);
        $user->fill($request);
        $user->save();

        Session::flash('message', "Successfully updated user " . $user->name());

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        throw new \ErrorException("Not implemented");
    }
}
