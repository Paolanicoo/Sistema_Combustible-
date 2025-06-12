<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroCombustibleController;
use App\Http\Controllers\RegistroVehicularController;
use App\Http\Controllers\ResumenImporteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReporteConsumoController;
use App\Http\Controllers\RegistroRolController;
use App\Http\Controllers\InventarioCombustibleController;
use App\Http\Controllers\UserController;

Route::middleware(['auth'])->group(function () {
    // RUTAS DE VEHÍCULO
    Route::get('registrovehicular/table', [RegistroVehicularController::class, 'getTableData'])->name('registrovehicular.table'); // Ruta para obtener datos de la tabla de vehículos.
    Route::get('registrovehicular', [RegistroCombustibleController::class, 'index'])->name('registrovehicular.index');// Ruta para mostrar el índice de vehículos.
    Route::get('/vehiculo_create', [RegistroVehicularController::class, 'create'])->name('registrovehicular.create');// Ruta para crear un nuevo vehículo.
    Route::post('/vehiculo_store', [RegistroVehicularController::class, 'store'])->name('registrovehicular.store'); // Ruta para almacenar un nuevo vehículo.
    Route::get('/registrovehicular/{id}/edit', [RegistroVehicularController::class, 'edit'])->name('registrovehicular.RVEdit'); // Ruta para editar un vehículo.
    Route::put('/registrovehicular/{id}', [RegistroVehicularController::class, 'update'])->name('registrovehicular.update'); // Ruta para actualizar un vehículo.
    Route::delete('/registrovehicular/{id}', [RegistroVehicularController::class, 'destroy'])->name('registrovehicular.destroy'); // Ruta para eliminar un vehículo.
    Route::get('registrovehicular/{id}', [RegistroVehicularController::class, 'show'])->name('registrovehicular.show'); // Ruta para mostrar detalles de un vehículo.
    Route::get('/registrovehicular/historial/{id}', [RegistroVehicularController::class, 'getHistorialAsignaciones'])->name('historialasignaciones.data');// Ruta para obtener el historial de asignaciones de un vehículo

    // RUTAS DE COMBUSTIBLE
    Route::get('registrocombustible/data', [RegistroCombustibleController::class, 'getTableData'])->name('registrocombustible.getTableData'); // Ruta para obtener datos de la tabla de combustible.
    Route::get('registrocombustible', [RegistroCombustibleController::class, 'index'])->name('registrocombustible.index'); // Ruta para mostrar el índice de combustible.
    Route::get('/combustible_create', [RegistroCombustibleController::class, 'create'])->name('registrocombustible.create'); // Ruta para crear un nuevo registro de combustible.
    Route::post('/combustible_store', [RegistroCombustibleController::class, 'store'])->name('registrocombustible.store'); // Ruta para almacenar un nuevo registro de combustible.
    Route::get('/registrocombustible/{id}/edit', [RegistroCombustibleController::class, 'edit'])->name('registrocombustible.edit'); // Ruta para editar un registro de combustible.
    Route::put('/registrocombustible/{id}', [RegistroCombustibleController::class, 'update'])->name('registrocombustible.update'); // Ruta para actualizar un registro de combustible.
    Route::delete('/registrocombustible/{id}', [RegistroCombustibleController::class, 'destroy'])->name('registrocombustible.destroy'); // Ruta para eliminar un registro de combustible.

    // RUTAS DE IMPORTE
    Route::get('registroimporte', [ResumenImporteController::class, 'index'])->name('registroimporte.index'); // Ruta para mostrar el índice de importes.
    Route::get('/registroimporte/table', [ResumenImporteController::class, 'getTableData'])->name('registroimporte.table'); // Ruta para obtener datos de la tabla de importes.
    Route::get('/importe_create', [ResumenImporteController::class, 'create'])->name('registroimporte.create'); // Ruta para crear un nuevo registro de importe.
    Route::post('/importe_store', [ResumenImporteController::class, 'store'])->name('registroimporte.store'); // Ruta para almacenar un nuevo registro de importe.
    Route::get('/registroimporte/{id}/edit', [ResumenImporteController::class, 'edit'])->name('registroimporte.edit'); // Ruta para editar un registro de importe.
    Route::put('/registroimporte/{id}', [ResumenImporteController::class, 'update'])->name('registroimporte.update'); // Ruta para actualizar un registro de importe.
    Route::delete('/registroimporte/{id}', [ResumenImporteController::class, 'destroy'])->name('registroimporte.destroy'); // Ruta para eliminar un registro de importe.
    Route::get('/vehiculo', [RegistroVehicularController::class, 'index'])->name('registrovehicular.index'); // Ruta para mostrar el índice de vehículos.
    Route::get('/combustible', [RegistroCombustibleController::class, 'index'])->name('registrocombustible.index'); // Ruta para mostrar el índice de combustible.
    Route::get('/importe', [ResumenImporteController::class, 'index'])->name('registroimporte.index'); // Ruta para mostrar el índice de importes.
       
    // RUTAS DE ROL
    Route::get('rol_table', [RegistroRolController::class, 'getData'])->name('registrorol.table'); // Ruta para obtener datos de la tabla de roles.
    Route::get('/roles/{id}/editar', [RegistroRolController::class, 'edit'])->name('roles.edit'); // Ruta para editar un rol.
    Route::post('/roles/{id}/editar', [RegistroRolController::class, 'update'])->name('roles.update'); // Ruta para actualizar un rol.
    Route::put('/roles/{id}/editar', [RegistroRolController::class, 'update'])->name('roles.update');
    Route::get('/roles/data', [RegistroRolController::class, 'getData'])->name('registrorol.table');// Ruta para obtener datos de roles.
    Route::post('/roles/toggleEstado', [RegistroRolController::class, 'toggleEstado'])->name('roles.toggleEstado'); // Ruta para alternar el estado de un rol.

    //RUTAS DE USER
    Route::get('/user_table', [UserController::class, 'getTableData'])->name('user.table'); // Ruta para obtener datos de la tabla de usuarios.
    Route::get('/user', [UserController::class, 'index'])->name('user.index'); // Ruta para mostrar el índice de usuarios.
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create'); // Ruta para crear un nuevo usuario.
    Route::post('/user', [UserController::class, 'store'])->name('user.store'); // Ruta para almacenar un nuevo usuario.
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');  // Ruta para editar un usuario.
    Route::put('/user/{id}/update', [UserController::class, 'update'])->name('user.update'); // Ruta para actualizar un usuario.
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('user.destroy');// Ruta para eliminar un usuario.

    // RUTAS DE INVENTARIO COMBUSTIBLE
    Route::get('/combustible/data', [InventarioCombustibleController::class, 'getData'])->name('combus.data'); // Ruta para obtener datos del inventario de combustible.
    Route::get('/InventarioCombustible/index', [InventarioCombustibleController::class, 'index'])->name('combus.index'); // Ruta para mostrar el índice del inventario de combustible.
    Route::get('/InventarioCombustible/create', [InventarioCombustibleController::class, 'create'])->name('combus.create');// Ruta para crear un nuevo registro en el inventario de combustible.
    Route::post('/InventarioCombustible/create', [InventarioCombustibleController::class, 'store'])->name('combustible.store'); // Ruta para almacenar un nuevo registro en el inventario de combustible.
    Route::get('/InventarioCombustible/{inventario}/edit', [InventarioCombustibleController::class, 'edit'])->name('combus.edit'); // Ruta para editar un registro en el inventario de combustible.
    Route::put('/InventarioCombustible/{inventario}', [InventarioCombustibleController::class, 'update'])->name('combus.update'); // Ruta para actualizar un registro en el inventario de combustible.
    Route::get('/InventarioCombustible/{inventario}', [InventarioCombustibleController::class, 'show'])->name('combus.show'); // Ruta para mostrar detalles de un registro en el inventario de combustible.
    Route::delete('/InventarioCombustible/{id}', [InventarioCombustibleController::class, 'destroy'])->name('combus.destroy'); // Ruta para eliminar un registro en el inventario de combustible.

    // MENÚ
    Route::get('/menu', function () { // Ruta para mostrar el menú.
        return view('menu'); // Retorna la vista del menú
    })->name('menu');
    
    // Rutas de reportes (protegidas ahora).
    Route::get('/reportes', function () { // Ruta para mostrar reportes.
        return view('reportes.RIndex'); // Retorna la vista de reportes.
    })->name('RIndex');
    
    Route::get('/reportes/consumo', [ReporteConsumoController::class, 'reportesConsumo'])->name('reportes.consumo'); // Ruta para mostrar reportes de consumo.
});

//INICIO DE SESION Y REGISTRO
Route::get('/login', [AuthController::class, 'showLogin'])->name('login'); // Ruta para mostrar el formulario de inicio de sesión.
Route::post('/login', [AuthController::class, 'login']);  // Ruta para procesar el inicio de sesión.

// RUTAS DE REGISTRO (solo para administradores).
Route::middleware(['auth', 'role:admin'])->group(function () { // Agrupa rutas que requieren autenticación y rol de administrador
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register'); // Ruta para mostrar el formulario de registro.
    Route::post('/register', [AuthController::class, 'register']); // Ruta para procesar el registro
});

// CERRAR SESIÓN
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');// Ruta para cerrar sesión.

// Redirección para cualquier ruta no definida
Route::fallback(function () { // Maneja rutas no definidas.
    if (auth()->check()) { // Verifica si el usuario está autenticado
        return redirect()->route('menu');  // Redirecciona a menú si está autenticado
    }
    return redirect()->route('login');  // Redirecciona a login si no está autenticado
});
