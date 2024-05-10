<?php
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\ProductoController;

Route::group(['middleware' => 'role:superAdmin'], function () {
    Route::get('/dashboard', function () {
        return Inertia::render('SuperAdmin/Dashboard');
    })->name('admin.dashboard');


    // TABLA USERS
    Route::apiResource('users', UserController::class);
    // TABLA ROLES
    Route::apiResource('roles', RoleController::class);
    // TABLA ORDENES
    Route::apiResource('ordenes', OrdenController::class);
    // TABLA PRODUCTOS
    Route::apiResource('productos', ProductoController::class);
    // TABLA DETALLE ORDENES
    Route::apiResource('detalle-ordenes', DetalleOrdenController::class);
    // TABLA ENVIOS
    Route::apiResource('envios', EnvioController::class);

});


