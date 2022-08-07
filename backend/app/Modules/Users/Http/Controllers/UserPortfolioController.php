<?php

namespace App\Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Aws\Services\AmazonS3Service;
use App\Modules\Users\Models\User;
use App\Modules\Users\Models\UserJsonAttribute;
use App\Modules\Users\Models\UserJsonAttributeKey;
use App\Modules\Users\Repositories\UserCertificationsRepository;
use App\Modules\Users\Repositories\UserDegreesRepository;
use App\Modules\Users\Repositories\UserExperiencesRepository;
use App\Modules\Users\Services\UserJsonAttributeService;
use Closure;
use ErrorException;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Inertia\Response;

class UserPortfolioController extends Controller
{

    /**
     * @param string $view
     * @return Response
     * @throws Exception
     */
    public function show(string $view): Response
    {
        $view = strtolower($view);

        $service = UserJsonAttributeService::newInstance(sprintf('system::portfolio::%s', $view));

        return $this->inertiaRender(sprintf('Portfolio/%s', ucfirst($view)), [
            $view => $service->getValue(Auth::id(), []),
            'dynamic_form_elements' => $service->getDynamicFormElements(),
        ]);
    }

    /**
     * @param string $view
     * @return RedirectResponse
     * @throws Exception
     */
    public function upsert(string $view): RedirectResponse
    {
        try {

            UserJsonAttributeService::newInstance(sprintf('system::portfolio::%s', $view))
                ->validate($data = request()->all())
                ->upsert(Auth::id(), $data);

            Session::flash("message", sprintf("Successfully Updated %s", ucfirst($view)));

        } catch (Exception $exception) {
            Session::flash('error_message', "There we're errors in your request. Please check the fields and try again.");
            throw $exception;
        }


        return redirect(route('dashboard.portfolio.show', $view));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ErrorException|ValidationException
     */
    public function uploadAvatar(Request $request): RedirectResponse
    {
        try {
            $this->validate($request, ['avatar' => 'required|image|max:' . 1024 * 5 /* 5 MB */]);
        } catch (Exception $exception) {
            Session::flash('error_message', $exception->getMessage());
            throw  $exception;
        }

        $s3File = AmazonS3Service::newInstance()->upload(
            'users::avatar_url',
            $request->file('avatar'),
            'users/avatars',
            ['model' => User::class],
        );

        /** @var User $user */
        $user = Auth::user();
        $user->update(['avatar_url' => $s3File->s3_url]);

        return redirect(route('dashboard.portfolio.show', 'details'));
    }
}
