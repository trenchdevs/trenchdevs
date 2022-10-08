<?php

namespace App\Modules\Users\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Controller;
use App\Modules\Emails\Models\EmailLog;
use App\Modules\Users\Models\UserPortfolioDetail;
use App\Modules\Users\Models\User;
use App\Modules\Users\Services\ValidatesUserTrait;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Inertia\Inertia;
use JetBrains\PhpStorm\ArrayShape;
use Throwable;

class UsersController extends Controller
{

    use ValidatesUserTrait;

    /**
     * Display a listing of the resource.
     *
     * @throws Exception
     */
    public function displayUsers(): \Inertia\Response
    {
        return $this->inertiaRender('Users/UsersList', [
            'data' => User::query()->paginate(10),
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function create(): \Illuminate\Contracts\View\View|Factory|Application
    {
        $this->adminCheckOrAbort();

        return view('admin.users.upsert', [
            'user' => new User,
            'action' => route('users.upsert'),
            'editMode' => false,
        ]);
    }

    /**
     * @param int|null $id
     * @return \Inertia\Response
     * @throws Exception
     */
    public function upsertForm(int $id = null): \Inertia\Response
    {
        return $this->inertiaRender('Users/UserUpsert', [
            'user' => User::query()->find($id),
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws ValidationException
     * @throws Throwable
     */
    public function upsertUser(Request $request): Redirector|RedirectResponse
    {
        $this->adminCheckOrAbort();


        $data = $request->all();
        $data['site_id'] = site_id();

        /** @var User $user */
        if ($request->id) { // update mode
            $this->validate($request, $this->validator(false));
            $user = User::query()->findOrFail($request->id);
            // password update is disabled via this panel
            unset($data['password'], $data['email']);
            $user->fill($data);
            $user->saveOrFail();

            Session::flash('message', "Successfully updated user " . $user->name());

        } else {

            $this->validate($request, $this->validator(true));

            $user = User::query()->create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'site_id' => site_id(),
                'is_active' => $data['is_active'],
                'email_verified_at' => date('Y-m-d H:i:s'),
                'role' => $data['role'],
                'password' => Hash::make($data['password'])
            ]);

            Session::flash('message', "Successfully created new user " . $user->name());
        }

        return redirect(site_route('dashboard.displayUsers'));
    }

    /**
     * Admin - send password reset email to user
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function passwordReset(Request $request): Redirector|RedirectResponse|Application
    {
        $this->adminCheckOrAbort();

        $id = $request->id ?? null;

        if (empty($id)) {
            abort(404);
        }

        /** @var User $user */
        $user = User::query()->findOrFail($id);

        $token = Password::getRepository()->create($user);
        $user->sendPasswordResetNotification($token);

        Session::flash('message', "Successfully sent password reset email to user " . $user->name());

        return redirect(site_route('dashboard.displayUsers'));
    }

    /**
     * @return \Inertia\Response
     * @throws Exception
     */
    public function showChangePasswordForm(): \Inertia\Response
    {
        return $this->inertiaRender('Account/ChangePassword');
    }

    /**
     * User changes own password
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function changePassword(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => RegisterController::PASSWORD_VALIDATION_RULE,
            'password_confirmation' => 'required',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if (!Hash::check($request->input('old_password'), $user->password)) {
            return back()->withErrors(['Please enter correct current password']);
        }

        $user->password = Hash::make($request->password);
        $user->saveOrFail();

        $viewData = [
            'name' => $user->name(),
            'email_body' => 'The system detected that your password was updated. '
                . 'If you have not make this update. Please contact support at support@trenchdevs.org',
        ];

        EmailLog::enqueue(
            $user->email,
            'Your password was Changed',
            $viewData,
        );

        return back()->with('message', 'Password reset successful.');
    }

}
