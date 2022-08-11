<?php

namespace App\Modules\Users\Http\Controllers;

use App\Modules\Aws\Services\AmazonS3Service;
use App\Services\UrlService;
use App\Modules\Users\Models\UserPortfolioDetail;
use App\Http\Controllers\Controller;
use App\Modules\Users\Models\User;
use ErrorException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class PortfolioController extends Controller
{

    const CUSTOM_URLS = [
        'lemuel' => 'https://trenchdevs-custom-portfolio.s3.amazonaws.com/lemuel-work-portfolio/index.html'
    ];

    /**
     * @var AmazonS3Service
     */
    private $s3Helper = null;

    /**
     * PortfolioController constructor.
     * @param AmazonS3Service $s3Helper
     */
    public function __construct(AmazonS3Service $s3Helper)
    {
        $this->s3Helper = $s3Helper;
    }

    private function handleCustomPortfolio(string $site)
    {

        if (empty($site)) {
            abort(404);
        }

        return view('portfolio.custom', [
            'site' => $site
        ]);
    }

    public function show(string $username)
    {

        $customSite = self::CUSTOM_URLS[$username] ?? null;

        if (!empty($customSite)) {
            $this->handleCustomPortfolio($customSite);
        }

        /**
         * at this point user has no custom site, use default
         */
        $user = User::findByUserName($username);

        if (!$user) {
            abort(404);
        }

        $portfolioDetails = $user->getPortfolioDetails();

        $view = $portfolioDetails->portfolio_view ?: 'portfolio.basic';

        return view($view, [
            'user' => $user,
        ]);

    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function update(Request $request)
    {

        $this->validate($request, [
            'primary_phone' => 'max:15',
            'github_url' => 'max:128',
            'linkedin_url' => 'max:128',
            'resume_url' => 'max:128',
            'interests' => 'max:500',
            'tagline' => 'max:1024',
        ]);

        /** @var User $user */
        $user = $request->user();

        $data = $request->all();
        $data['user_id'] = $user->id;
        $data = UserPortfolioDetail::sanitizeFields($data);
        $portfolioDetail = $user->getPortfolioDetails();
        $portfolioDetail->fill($data);
        $portfolioDetail->saveOrFail();

        return back()->with('message', 'Thank you, Your profile has been updated');
    }

    public function edit(Request $request)
    {
        $user = $request->user();

        $portfolioDetail = UserPortfolioDetail::findOrEmptyByUser($user->id);

        return view('portfolio.edit', [
            'user' => $user,
            'portfolio_detail' => $portfolioDetail,
        ]);
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     * @throws Throwable
     */
    public function updateBasicInfo(Request $request)
    {


        $this->validate($request, [
            'external_id' => 'required|max:25|alpha_num',
            'portfolio_view' => [
                'required',
                'max:50',
                Rule::in(array_keys(UserPortfolioDetail::VALID_VIEWS)),

            ],
        ]);

        /** @var User $user */
        $user = $request->user();

        DB::transaction(function () use ($user, $request) {
            $user->external_id = $request->get('username');
            $user->saveOrFail();
            $portfolioDetails = $user->getPortfolioDetails();
            $portfolioDetails->user_id = $user->id;
            $portfolioDetails->portfolio_view = $request->get('portfolio_view');
            $portfolioDetails->saveOrFail();
        });

        return back()->with('message', 'Thank you, your basic profile have been updated');
    }

}
