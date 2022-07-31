<?php

namespace App\Http\Controllers;


use App\Modules\Sites\Models\ApplicationType;
use App\Http\Controllers\Auth\ApiController;
use App\Http\Controllers\Auth\RegisterController;
use App\Modules\Sites\Models\Sites\SiteFactory;
use App\Modules\Users\Models\User;
use ErrorException;
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

            if (!$site = SiteFactory::getInstanceOrNull()) {
                throw new ErrorException("Forbidden");
            }

            $request['role'] = $site->getDefaultRole();

            $validator = Validator::make($request->all(), $site->registrationValidationRules());

            if ($validator->fails()) {
                throw ValidationException::withMessages($validator->errors()->toArray());
            }

            $appType = $site->getAppType();

            try {

                DB::beginTransaction();

                /** @var Account $account */
                $account = Account::query()->create([
                    'application_type_id' => $appType->id,
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
     * @param bool $deleteTokens
     * @return array
     */
    private function generateTokenResponse(User $user, bool $deleteTokens = false)
    {
        if ($deleteTokens) {
            $user->tokens()->delete();
        }

        $name = request()->userAgent() ?: "N/A";

        return [
            'access_token' => $user->createToken(md5($name))->plainTextToken, // md5 - temp edit
            'access_token_type' => 'bearer',
        ];
    }

    public function sud()
    {

        return $this->responseHandler(function () {

            $userId = request()->post('user_id');

            /** @var User $loggedInUser */
            $loggedInUser = $this->auth->user();

            if ($loggedInUser->role !== User::ROLE_SUPER_ADMIN) {
                return "Forbidden";
            }

            if (!$user = User::query()->find($userId)) {
                throw new InvalidArgumentException("Forbidden");
            }

            return array_merge($this->generateTokenResponse($user), $user->toArray());
        });

    }
}
