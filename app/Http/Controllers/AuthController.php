<?php

namespace App\Http\Controllers;

use App\Account;
use App\Http\Controllers\Auth\ApiController;
use App\Http\Controllers\Auth\RegisterController;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Laravel\Sanctum\Guard;

class AuthController extends ApiController
{

    /** @var Guard */
    protected $auth = null;

    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->auth = auth();
    }

    /**
     * Main Registration route
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {

        // START: Temporary code
        $accountId = $request->header('x-account-id');

        if (!$accountId) {
            throw new InvalidArgumentException("Access Denied.");
        }

        $account = Account::query()->where('id', $accountId)->first();

        if (!$account) {
            throw new InvalidArgumentException("Access Denied.");
        }

        if ($account->business_name === "TrenchDevs Marketale") {
            $request['account_id'] = $account->id;
            $request['role'] = User::ROLE_BUSINESS_OWNER;
        }
        // END: Temporary code

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => RegisterController::PASSWORD_VALIDATION_RULE,
            'role' => [
                'required',
                Rule::in([User::ROLE_BUSINESS_OWNER, User::ROLE_CUSTOMER]),
            ],
            'account_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->validationFailuresResponse($validator);
        }

        /** @var User $user */
        $user = User::query()->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
            'account_id' => $request->account_id,
        ]);

        return $this->respondWithToken($user);
    }

    /**
     * Main login
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        return $this->responseHandler(function () use ($request) {

            $this->validate($request, [
                'email' => 'required',
                'password' => 'required'
            ]);

            /** @var User $user */
            $user = User::query()->where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            return array_merge($this->generateTokenResponse($user), $user->toArray());
        });
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me()
    {
        return $this->responseHandler(function () {

            /** @var User $loggedInUser */
            $loggedInUser = $this->auth->user();

            if (empty($loggedInUser)) {
                throw new InvalidArgumentException("Access Denied.");
            }

            return $loggedInUser;
        });
    }

    /**
     * Invalidates the old token & returns a new one
     * @return JsonResponse
     */
    public function refreshToken()
    {
        return $this->responseHandler(function () {
            /** @var User $user */
            $user = $this->auth->user();
            return $this->generateTokenResponse($user);
        });
    }

    /**
     * Invalidates the token
     * @return JsonResponse
     */
    public function logout()
    {
        return $this->responseHandler(function () {
            /** @var User $user */
            $user = $this->auth->user();
            $user->tokens()->delete();
        });
    }


    /**
     * @param User $user
     * @return JsonResponse
     */
    protected function respondWithToken(User $user)
    {
        return $this->jsonApiResponse(self::STATUS_SUCCESS, 'Success', $this->generateTokenResponse($user));
    }

    /**
     * @param User $user
     * @return array
     */
    private function generateTokenResponse(User $user)
    {
        $user->tokens()->delete();

        $name = request()->userAgent() ?: "N/A";

        return [
            'access_token' => $user->createToken($name)->plainTextToken,
            'access_token_type' => 'bearer',
        ];
    }
}
