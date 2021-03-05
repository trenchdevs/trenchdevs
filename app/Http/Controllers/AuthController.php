<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\ApiController;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\JWTGuard;

class AuthController extends ApiController
{

    /** @var JWTGuard */
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

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required',
            'role' => [
                'required',
                Rule::in([User::ROLE_BUSINESS_OWNER, User::ROLE_CUSTOMER]),
            ],
            'account_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->validationFailureResponse($validator);
        }

        $user = User::query()->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
            'account_id' => $request->account_id,
        ]);

        return $this->respondWithToken($this->auth->login($user));
    }

    /**
     * Main login
     * @return JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = $this->auth->attempt($credentials)) {
            return response()->json(['error' => 'Invalid Credentials'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me()
    {
        return $this->jsonApiResponse('success', 'Success', $this->auth->user());
    }

    /**
     * Invalidates the old token & returns a new one
     * @return JsonResponse
     */
    public function refreshToken()
    {
        return $this->jsonApiResponse(self::STATUS_SUCCESS, "Success", [
            'token' => $this->auth->refresh(),
        ]);
    }

    /**
     * Invalidates the token
     * @return JsonResponse
     */
    public function logout()
    {
        $this->auth->logout();
        return $this->jsonApiResponse(self::STATUS_SUCCESS, 'Successfully logged out');
    }

    /**
     * @param $token
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return $this->jsonApiResponse(self::STATUS_SUCCESS, 'Success', [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->auth->factory()->getTTL() * 60
        ]);
    }
}
