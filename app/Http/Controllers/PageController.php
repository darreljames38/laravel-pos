<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display the main SystemHub landing page.
     */
    public function index(): View
    {
        return view('landing');
    }

    /**
     * Display the public About page.
     */
    public function about(): View
    {
        return view('about');
    }
}