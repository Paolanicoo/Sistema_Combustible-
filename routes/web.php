<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroCombustibleController;
use App\Http\Controllers\RegistroVehicularController;
use App\Http\Controllers\ResumenImporteController;


// RUTAS DE VEHICULO

// INDEX
Route::get('/vehiculo',[RegistroVehicularController::class,'index'])->name('registrovehicular.index');

//Create
Route::get('/vehiculo_create',[RegistroVehicularController::class,'create'])->name('registrovehicular.create');
//Store
Route::post('/vehiculo_store',[RegistroVehicularController::class,'store'])->name('registrovehicular.store');



// RUTAS DE COMBUSTIBLE

// INDEX
Route::get('/combustible',[RegistroCombustibleController::class,'index'])->name('registrocombustible.index');

//Create
Route::get('/combustible_create',[RegistroCombustibleController::class,'create'])->name('registrocombustible.create');
//Store
Route::post('/combustible_store',[RegistroCombustibleController::class,'store'])->name('registrocombustible.store');





// RUTAS DE IMPORTE

// INDEX
Route::get('/importe',[ResumenImporteController::class,'index'])->name('registroimporte.index');

//Create
Route::get('/importe_create',[ResumenImporteController::class,'create'])->name('registroimporte.create');
//store
Route::post('/importe_store',[ResumenImporteController::class,'store'])->name('registroimporte.store');

