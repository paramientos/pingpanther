<?php

namespace App\Http\Controllers;

use App\Models\Website;

class WebsiteController extends Controller
{
    public function index()
    {
        return view('websites.index');
    }

    public function show(Website $website)
    {
        return view('websites.show', compact('website'));
    }
}
