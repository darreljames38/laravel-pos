<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    public function index()
    {
        return view('tasks.about');
    }
}