<?php

namespace App\Http\Controllers;

use App\Account;
use App\ApplicationType;
use App\Http\Controllers\Auth\ApiController;
use App\Http\Controllers\Auth\RegisterController;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Laravel\Sanctum\Guard;
use Exception;

class AuthController extends ApiController
{

    const VALID_ECOMMERCE_DOMAINS = [
        'http://localhost:3000',
        'https://localhost:3000',
        'https://marketale.trenchapps.com/',
    ];

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

        return $this->responseHandler(function () use ($request) {

            // todo: Consult Chris as this can be spoofed
            if (in_array($request->header('origin'), self::VALID_ECOMMERCE_DOMAINS)) {
                $request['role'] = User::ROLE_BUSINESS_OWNER;
            }

            $validator = Validator::make($request->all(), [
                'shop_name' => 'required|string|max:255', // todo: this should only be validated if request came from Marketale
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => RegisterController::PASSWORD_VALIDATION_RULE,
                'password_confirmation' => 'required|string|min:8',
                'role' => [
                    'required',
                    Rule::in([User::ROLE_BUSINESS_OWNER, User::ROLE_CUSTOMER]),
                ]
            ]);

            if ($validator->fails()) {
                throw ValidationException::withMessages($validator->errors()->toArray());
            }

            $ecommerceAppType = ApplicationType::getEcommerceApplicationType();

            if (!$ecommerceAppType) {
                throw new InvalidArgumentException("Non existing ecommerce application type.");
            }

            $existingAccount = Account::findByAccountIdAndBusinessName($ecommerceAppType->id, $request->shop_name);

            if ($existingAccount) {
                throw ValidationException::withMessages([
                    'shop_name' => ['This shop name has already been taken.'] // todo: this should only be validated if request came from Marketale
                ]);
            }

            try {

                DB::beginTransaction();

                /** @var Account $account */
                $account = Account::query()->create([
                    'application_type_id' => $ecommerceAppType->id,
                    'business_name' => $request->shop_name,
                ]);

                /** @var User $user */
                $user = User::query()->create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => $request->role,
                    'account_id' => $account->id,
                ]);

                $account->owner_user_id = $user->id;
                $account->saveOrFail();

                DB::commit();

            } catch (Exception $exception) {
                DB::rollBack();
                throw new Exception("There was a problem in processing your registration.");
            }

            return array_merge($this->generateTokenResponse($user), $user->toArray());

        });
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
