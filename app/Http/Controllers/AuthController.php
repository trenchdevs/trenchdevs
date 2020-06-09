<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
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

        $user = User::create([
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
            'account_id' => $request->account_id,
        ]);

        $token = auth()->login($user);

        return $this->respondWithToken($token);

    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
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
        return response()->json(auth()->user());
    }

    /**
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }


    /**
     * @param $token
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
