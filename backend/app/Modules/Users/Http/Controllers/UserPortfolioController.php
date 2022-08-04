<?php

namespace App\Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Users\Models\User;
use App\Modules\Users\Models\UserJsonAttribute;
use App\Modules\Users\Repositories\UserCertificationsRepository;
use App\Modules\Users\Repositories\UserDegreesRepository;
use App\Modules\Users\Repositories\UserExperiencesRepository;
use App\Modules\Users\Services\UserJsonAttributeService;
use Closure;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
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

        return $this->inertiaRender(sprintf('Portfolio/%s', ucfirst($view)), [
            $view =>  UserJsonAttributeService::newInstance(sprintf('system::portfolio::%s', $view))->getValue(Auth::id()),
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
}
