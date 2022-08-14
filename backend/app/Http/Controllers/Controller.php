<?php

namespace App\Http\Controllers;

use App\Modules\Sites\Models\Site;
use App\Modules\Users\Models\User;
use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Inertia;
use Inertia\Response;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';

    /**
     * @var Site
     */
    protected Site $site;


    /**
     * AuthWebController constructor.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->middlewareOnConstructorCalled();
            return $next($request);
        });
    }


    public function middlewareOnConstructorCalled(): void
    {
        // do custom logic per controller
        $this->site = site();
    }

    /**
     * @param string $status
     * @param string $message
     * @param array $dataOverride
     * @param array $errors
     * @return JsonResponse
     */
    protected function jsonResponse(string $status, string $message, array $dataOverride = [], array $errors = []): JsonResponse
    {

        $response = [
            'status' => $status,
            'message' => $message,
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        if (!empty($dataOverride)) {
            $response = array_merge($response, $dataOverride);
        }

        return response()->json($response);
    }

    /**
     * @param Validator $validator
     * @param string $errorMsg
     * @return JsonResponse
     */
    protected function validationFailureResponse(Validator $validator, string $errorMsg = "Validation Error"): JsonResponse
    {
        return $this->jsonResponse(
            self::STATUS_ERROR,
            $errorMsg,
            [],
            $validator->errors()->all()
        );
    }

    /**
     * @return bool
     */
    protected function isLoggedInUserAdmin(): bool
    {

        /** @var User $loggedInUser */
        $loggedInUser = request()->user();

        return !empty($loggedInUser) && $loggedInUser->isAdmin();
    }

    /**
     * @param string $message
     */
    protected function adminCheckOrAbort(string $message = "Feature not enabled for account. Please contact admin if you require elevated access"): void
    {
        if (!$this->isLoggedInUserAdmin()) {
            abort('403', $message);
        }
    }

    /**
     * @param string $jsxPage
     * @param array $props
     * @return Response
     * @throws Exception
     */
    public function inertiaRender(string $jsxPage, array $props = []): Response
    {
        $inertiaTheme = site()->inertia_theme ?? 'Default';
        $inertialPath = "Themes/$inertiaTheme/Pages/$jsxPage";
        $filePath = "resources/js/$inertialPath.jsx";

        if (!file_exists(base_path($filePath))) {
            throw new Exception("Inertia view does not exists on path $filePath ($inertialPath)");
        }

        return Inertia::render($inertialPath, $props);
    }

}
