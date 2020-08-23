<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
{

    const CUSTOM_URLS = [
        'lemuel' => 'https://trenchdevs-custom-portfolio.s3.amazonaws.com/lemuel-work-portfolio/index.html'
    ];


    public function show(string $username)
    {

        $site = self::CUSTOM_URLS[$username] ?? null;

        if (empty($site)) {
            abort(404);
        }

        return view('portfolio.custom', [
            'site' => $site
        ]);

    }

    public function preview()
    {
        return view('portfolio.show', [
            'user' => Auth::user()
        ]);
    }
}
