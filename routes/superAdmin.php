<?php
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserController;

Route::get('/dashboard', function () {
    return Inertia::render('SuperAdmin/Dashboard');
}) ->name('dashboard');

Route::resource('users', UserController::class);
