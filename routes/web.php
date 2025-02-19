<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroCombustibleController;
use App\Http\Controllers\RegistroVehicularController;
use App\Http\Controllers\ResumenImporteController;




// RUTAS DE VEHICULO

// INDEX
Route::get('/',[RegistroVehicularController::class,'index'])->name('registrovehicular.index');

//Create
Route::get('/vehiculo_create',[RegistroVehicularController::class,'create'])->name('registrovehicular.create');
//Store
Route::post('/vehiculo_store',[RegistroVehicularController::class,'store'])->name('registrovehicular.store');

// EDIT Y UPDATE 
Route::get('/registrovehicular/{id}/edit', [RegistroVehicularController::class, 'edit'])->name('registrovehicular.RVEdit');

Route::put('/registrovehicular/{id}', [RegistroVehicularController::class, 'update'])->name('registrovehicular.update');

//ELIMINAR
Route::delete('/registrovehicular/{id}', [RegistroVehicularController::class, 'destroy'])
    ->name('registrovehicular.destroy');




// RUTAS DE COMBUSTIBLE

// INDEX
Route::get('/combustible',[RegistroCombustibleController::class,'index'])->name('registrocombustible.index');

//Create
Route::get('/combustible_create',[RegistroCombustibleController::class,'create'])->name('registrocombustible.create');
//Store
Route::post('/combustible_store',[RegistroCombustibleController::class,'store'])->name('registrocombustible.store');

//EDIT Y UPDATE
Route::get('/registrocombustible/{id}/edit', [RegistroCombustibleController::class, 'edit'])->name('registrocombustible.edit');
Route::put('/registrocombustible/{id}', [RegistroCombustibleController::class, 'update'])->name('registrocombustible.update');

//Eliminar
Route::delete('/registrocombustible/{id}', [RegistroCombustibleController::class, 'destroy'])->name('registrocombustible.destroy');








// RUTAS DE IMPORTE

// INDEX
Route::get('/importe',[ResumenImporteController::class,'index'])->name('registroimporte.index');

//Create
Route::get('/importe_create',[ResumenImporteController::class,'create'])->name('registroimporte.create');
//store
Route::post('/importe_store',[ResumenImporteController::class,'store'])->name('registroimporte.store');

Route::get('/registroimporte/{id}/edit', [ResumenImporteController::class, 'edit'])->name('registroimporte.edit');
Route::put('/registroimporte/{id}', [ResumenImporteController::class, 'update'])->name('registroimporte.update');

//eliminar
Route::delete('/registroimporte/{id}', [ResumenImporteController::class, 'destroy'])->name('registroimporte.destroy');


//Rutas usuario


