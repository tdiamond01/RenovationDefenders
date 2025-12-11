<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    /**
     * Display the About Us page.
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * Display the Services & Pricing page.
     */
    public function services()
    {
        return view('pages.services');
    }

    /**
     * Display the Starter Guide page.
     */
    public function starterGuide()
    {
        return view('pages.starter-guide');
    }
}
