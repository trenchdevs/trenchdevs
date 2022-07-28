<?php

namespace App\Public\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PublicPagesController extends Controller
{
    public function about(): View
    {
        return $this->siteViewOrDefault('public.pages.about');
    }
}
