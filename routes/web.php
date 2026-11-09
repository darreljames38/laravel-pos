<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Tasks\AboutController as TasksAboutController;
use App\Http\Controllers\Tasks\ProfileController;
use App\Http\Controllers\Tasks\TaskController;
use App\Http\Controllers\Tasks\WelcomeController;
use Illuminate\Support\Facades\Route;

// Tasks for Today
Route::get('/', [WelcomeController::class, 'index'])
    ->name('tasks.today');

Route::get('/tasks', [TaskController::class, 'index'])
    ->name('tasks.index');

Route::get('/profile', [ProfileController::class, 'index'])
    ->name('tasks.profile');

Route::get('/about', [TasksAboutController::class, 'index'])
    ->name('tasks.about');

// POS System
Route::get('/pos', [PageController::class, 'landing'])
    ->name('pos.home');

Route::resource('customers', CustomerController::class)
    ->only([
        'index',
        'create',
        'store',
        'edit',
        'update',
    ]);

Route::resource('users', UserController::class)
    ->only([
        'index',
        'create',
        'store',
        'edit',
        'update',
    ]);

Route::get('/pos/about', [PageController::class, 'about'])
    ->name('pos.about');