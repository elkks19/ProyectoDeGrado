<?php
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserController;

Route::group(['middleware' => 'role:superAdmin'], function () {
    Route::get('/dashboard', function () {
        return Inertia::render('SuperAdmin/Dashboard');
    })->name('admin.dashboard');
});

Route::resource('users', UserController::class);
