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

Route::get('/customers', [CustomerController::class, 'index'])
    ->name('customers.index');

Route::get('/users', [UserController::class, 'index'])
    ->name('users.index');

Route::get('/pos/about', [PageController::class, 'about'])
    ->name('pos.about');