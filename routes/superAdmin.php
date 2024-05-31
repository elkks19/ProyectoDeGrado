<?php
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\EnvioController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\DivisaController;

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
    // TABLA ENVIOS
    Route::apiResource('envios', EnvioController::class);
    // TABLA CATEGORIAS
    Route::apiResource('categorias', CategoriaController::class);
    // TABLA METODOS DE PAGO
    Route::apiResource('metodos-de-pago', MetodoPagoController::class);
    // TABLA DIVISAS
    Route::apiResource('divisas', DivisaController::class);

});


