<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Models\Tasks\User;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::first();

        return view('tasks.profile', compact('user'));
    }
}