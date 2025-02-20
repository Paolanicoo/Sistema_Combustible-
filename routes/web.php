<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroCombustibleController;
use App\Http\Controllers\RegistroVehicularController;
use App\Http\Controllers\ResumenImporteController;
use App\Http\Controllers\AuthController;





Route::middleware(['auth'])->group(function () {
    // RUTAS DE VEHÍCULO
    Route::get('/', [RegistroVehicularController::class, 'index'])->name('registrovehicular.index');
    Route::get('/vehiculo_create', [RegistroVehicularController::class, 'create'])->name('registrovehicular.create');
    Route::post('/vehiculo_store', [RegistroVehicularController::class, 'store'])->name('registrovehicular.store');
    Route::get('/registrovehicular/{id}/edit', [RegistroVehicularController::class, 'edit'])->name('registrovehicular.RVEdit');
    Route::put('/registrovehicular/{id}', [RegistroVehicularController::class, 'update'])->name('registrovehicular.update');
    Route::delete('/registrovehicular/{id}', [RegistroVehicularController::class, 'destroy'])->name('registrovehicular.destroy');

    // RUTAS DE COMBUSTIBLE
    Route::get('/combustible', [RegistroCombustibleController::class, 'index'])->name('registrocombustible.index');
    Route::get('/combustible_create', [RegistroCombustibleController::class, 'create'])->name('registrocombustible.create');
    Route::post('/combustible_store', [RegistroCombustibleController::class, 'store'])->name('registrocombustible.store');
    Route::get('/registrocombustible/{id}/edit', [RegistroCombustibleController::class, 'edit'])->name('registrocombustible.edit');
    Route::put('/registrocombustible/{id}', [RegistroCombustibleController::class, 'update'])->name('registrocombustible.update');
    Route::delete('/registrocombustible/{id}', [RegistroCombustibleController::class, 'destroy'])->name('registrocombustible.destroy');

    // RUTAS DE IMPORTE
    Route::get('/importe', [ResumenImporteController::class, 'index'])->name('registroimporte.index');
    Route::get('/importe_create', [ResumenImporteController::class, 'create'])->name('registroimporte.create');
    Route::post('/importe_store', [ResumenImporteController::class, 'store'])->name('registroimporte.store');
    Route::get('/registroimporte/{id}/edit', [ResumenImporteController::class, 'edit'])->name('registroimporte.edit');
    Route::put('/registroimporte/{id}', [ResumenImporteController::class, 'update'])->name('registroimporte.update');
    Route::delete('/registroimporte/{id}', [ResumenImporteController::class, 'destroy'])->name('registroimporte.destroy');

// Muestra el formulario de inicio de sesión
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Muestra el formulario de registro
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Cerrar sesión
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



    // MENÚ
    Route::get('/menu', function () {
        return view('menu');
    })->name('menu');
});
