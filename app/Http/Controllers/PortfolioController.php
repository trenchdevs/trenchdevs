<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortfolioController extends Controller
{

    const CUSTOM_URLS = [
        'lemuel' => 'https://trenchdevs-custom-portfolio.s3.amazonaws.com/lemuel-work-portfolio/index.html'
    ];


    public function show(string $username){

        $site = self::CUSTOM_URLS[$username];

        return view('portfolio.custom', ['site' => $site]);

    }
}
