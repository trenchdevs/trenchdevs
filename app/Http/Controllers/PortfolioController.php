<?php

namespace App\Http\Controllers;

use App\Helpers\AmazonS3Helper;
use App\Helpers\UrlHelper;
use App\Models\Users\UserPortfolioDetail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
{

    const CUSTOM_URLS = [
        'lemuel' => 'https://trenchdevs-custom-portfolio.s3.amazonaws.com/lemuel-work-portfolio/index.html'
    ];

    /**
     * @var AmazonS3Helper
     */
    private $s3Helper = null;

    /**
     * PortfolioController constructor.
     * @param AmazonS3Helper $s3Helper
     */
    public function __construct(AmazonS3Helper $s3Helper)
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
            $this->handleCustomPortfolio();
        }

        /**
         * at this point user has no custom site, use default
         */
        $user = User::findByUserName($username);

        if (!$user) {
            abort(404);
        }

        return view('portfolio.show', [
            'user' => $user,
            'portfolio_details' => $user->getPortfolioDetails(),
        ]);

    }

    public function update(Request $request, UrlHelper $urlHelper)
    {

        $this->validate($request, [
            'primary_phone' => 'required|max:15',
            'github_url' => 'required|max:128',
            'linkedin_url' => 'required|max:128',
            'resume_url' => 'required|max:128',
            'interests' => 'max:500',
            'tagline' => 'max:500',
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

    public function uploadAvatar(Request $request)
    {

        $this->validate($request, [
            'avatar_url' => 'required|max:10000|mimes:jpeg,jpg,png',
            'username' => 'required|max:25',
        ]);

        /** @var User $user */
        $user = $request->user();
        $avatarFile = $request->file('avatar_url');

        $fileName = sprintf("%s_%s", $user->id, md5($user->name()));
        $s3FullPath = $this->s3Helper->upload($avatarFile, 'users/avatars', $fileName);

        $user->avatar_url = $s3FullPath;
        $user->username = $request->username;
        $user->saveOrFail();

        return back()->with('message', 'Thank you, your basic profile have been updated');
    }

    public function uploadBackground(Request $request)
    {
        $this->validate($request, [
            'background_cover_url' => 'required|max:10000|mimes:jpeg,jpg,png'
        ]);

        /** @var User $user */
        $user = $request->user();
        $avatarFile = $request->file('background_cover_url');

        $fileName = sprintf("%s_%s", $user->id, md5($user->name()));
        $s3FullPath = $this->s3Helper->upload($avatarFile, 'users/background_covers', $fileName);

        $portfolioDetails = $user->getPortfolioDetails();
        $portfolioDetails->background_cover_url = $s3FullPath;
        $portfolioDetails->saveOrFail();

        return back()->with('message', 'Thank you, Your background cover was saved Successfully');
    }

    public function preview()
    {
        $user = Auth::user();
        $baseUrl = env('BASE_URL');
        return redirect("//{$user->username}.{$baseUrl}");
    }

    public function showSecurity()
    {
        return view('portfolio.security', [
            'user' => Auth::user(),
        ]);
    }
}