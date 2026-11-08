<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Models\Tasks\Task;

class WelcomeController extends Controller
{
    public function index()
    {
        $tasks = Task::whereDate('task_date', today())
            ->orderBy('task_date')
            ->get();

        return view('tasks.welcome', compact('tasks'));
    }
}