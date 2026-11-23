<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Tasks\ProfileController as TaskProfileController;
use App\Http\Controllers\Tasks\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public pages
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'index'])
    ->name('home');

Route::get('/about', [PageController::class, 'about'])
    ->name('about');

/*
|--------------------------------------------------------------------------
| Public Task Management pages
|--------------------------------------------------------------------------
*/

Route::get('/today', [TaskController::class, 'today'])
    ->name('tasks.today');

Route::get('/tasks', [TaskController::class, 'index'])
    ->name('tasks.index');

Route::get('/profile', [TaskProfileController::class, 'show'])
    ->name('profile.show');

/*
|--------------------------------------------------------------------------
| Protected POS and Task management
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | POS management
    |--------------------------------------------------------------------------
    */

    Route::resource('customers', CustomerController::class);

    Route::resource('users', UserController::class);

    /*
    |--------------------------------------------------------------------------
    | Task management
    |--------------------------------------------------------------------------
    */

    Route::get('/tasks/create', [TaskController::class, 'create'])
        ->name('tasks.create');

    Route::post('/tasks', [TaskController::class, 'store'])
        ->name('tasks.store');

    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])
        ->name('tasks.edit');

    Route::put('/tasks/{task}', [TaskController::class, 'update'])
        ->name('tasks.update');

    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])
        ->name('tasks.destroy');
});

/*
|--------------------------------------------------------------------------
| Breeze authentication
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';