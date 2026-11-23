<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(): View
    {
        $user = auth()->user();

        return view('tasks.profile', compact('user'));
    }
}