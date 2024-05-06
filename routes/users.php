<?php
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserController;

Route::get('/store', function () {
    return Inertia::render('Usuario/Store');
})->name('store');

Route::get('/store/dashboard', function () {
    return Inertia::render('Store/Dashboard');
})->name('store.dashboard');


Route::middleware('auth:sanctum')->group(function (){
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update');

        Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});


