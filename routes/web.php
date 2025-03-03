<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroCombustibleController;
use App\Http\Controllers\RegistroVehicularController;
use App\Http\Controllers\ResumenImporteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReporteConsumoController;
use App\Http\Controllers\RegistroRolController;

Route::middleware(['auth'])->group(function () {
    // RUTAS DE VEHÍCULO
    Route::get('registrovehicular/table', [RegistroVehicularController::class, 'getTableData'])->name('registrovehicular.table');
    Route::get('/vehiculo_create', [RegistroVehicularController::class, 'create'])->name('registrovehicular.create');
    Route::post('/vehiculo_store', [RegistroVehicularController::class, 'store'])->name('registrovehicular.store');
    Route::get('/registrovehicular/{id}/edit', [RegistroVehicularController::class, 'edit'])->name('registrovehicular.RVEdit');
    Route::put('/registrovehicular/{id}', [RegistroVehicularController::class, 'update'])->name('registrovehicular.update');
    Route::delete('/registrovehicular/{id}', [RegistroVehicularController::class, 'destroy'])->name('registrovehicular.destroy');

    // RUTAS DE COMBUSTIBLE
    Route::get('registrocombustible/data', [RegistroCombustibleController::class, 'getTableData'])->name('registrocombustible.getTableData');

    Route::get('/combustible_create', [RegistroCombustibleController::class, 'create'])->name('registrocombustible.create');
    Route::post('/combustible_store', [RegistroCombustibleController::class, 'store'])->name('registrocombustible.store');
    Route::get('/registrocombustible/{id}/edit', [RegistroCombustibleController::class, 'edit'])->name('registrocombustible.edit');
    Route::put('/registrocombustible/{id}', [RegistroCombustibleController::class, 'update'])->name('registrocombustible.update');
    Route::delete('/registrocombustible/{id}', [RegistroCombustibleController::class, 'destroy'])->name('registrocombustible.destroy');

    // RUTAS DE IMPORTE
    Route::get('registroimporte', [ResumenImporteController::class, 'index'])->name('registroimporte.index');
    Route::get('/importe_create', [ResumenImporteController::class, 'create'])->name('registroimporte.create');
    Route::post('/importe_store', [ResumenImporteController::class, 'store'])->name('registroimporte.store');
    Route::get('/registroimporte/{id}/edit', [ResumenImporteController::class, 'edit'])->name('registroimporte.edit');
    Route::put('/registroimporte/{id}', [ResumenImporteController::class, 'update'])->name('registroimporte.update');
    Route::delete('/registroimporte/{id}', [ResumenImporteController::class, 'destroy'])->name('registroimporte.destroy');


    Route::get('/vehiculo', [RegistroVehicularController::class, 'index'])->name('registrovehicular.index');
    Route::get('/combustible', [RegistroCombustibleController::class, 'index'])->name('registrocombustible.index');
    Route::get('/importe', [ResumenImporteController::class, 'index'])->name('registroimporte.index');
       
    // RUTAS DE ROL
    Route::get('rol_table', [RegistroRolController::class, 'getData'])->name('registrorol.table');

    // Ruta para editar un rol
    Route::get('/roles/editar/{id}', [RegistroRolController::class, 'editarRol']);

    // Ruta para desactivar un rol
    Route::post('/roles/desactivar/{id}', [RegistroRolController::class, 'desactivarRol']);


    // MENÚ
    Route::get('/menu', function () {
        return view('menu');
    })->name('menu');
});

//INICIO DE SESION Y REGISTRO
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Muestra el formulario de registro
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Cerrar sesión
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/reportes', function () {
    return view('reportes.RIndex');
})->name('RIndex');

Route::get('/reportes/consumo', [ReporteConsumoController::class, 'reportesConsumo'])->name('reportes.consumo');
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
