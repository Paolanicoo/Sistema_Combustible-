<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroCombustibleController;
use App\Http\Controllers\RegistroVehicularController;
use App\Http\Controllers\ResumenImporteController;

// INDEX
Route::get('/',[RegistroVehicularController::class,'index'])->name('registrovehicular.index');